<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash; //para usar la función de hash para las contraseñas. Hash::check() y Hash::make() son el estándar Laravel; evita mezclar password_verify con bcrypt

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HasFactory, Notifiable, HasApiTokens;

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'], //"unique:" impide duplicados (fundamental para login).
            'pregunta' => ['required', 'string', 'max:255'],
            'respuesta' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->pregunta = $validated['pregunta'];
        $user->respuesta = $validated['respuesta'];
        $user->password = Hash::make($validated['password']); //"Hash::make()" genera un hash seguro para la contraseña, en lugar de usar bcrypt directamente
        $user->save();

        return response()->json($user, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Solo actualiza la contraseña si se proporciona una nueva, y siempre usando Hash::make para asegurar que se guarde de forma segura
        }
        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function login(Request $request)
    {
        // 1) Validamos que el request traiga los campos mínimos y con formato correcto.
        // Si falta email/password o el email no es válido, Laravel responde 422 automáticamente.
        $validated = $request->validate([
            'email' => ['required', 'email'],       // required = obligatorio; email = debe tener formato email
            'password' => ['required', 'string'],   // required = obligatorio; string = debe ser texto
        ]);

        // 2) Buscamos el usuario en la base de datos por su email.
        // first() retorna el primer resultado o null si no existe.
        $user = User::where('email', $validated['email'])->first();

        // 3) Verificamos credenciales:
        // - Si el usuario NO existe -> $user es null -> credenciales incorrectas.
        // - Si existe, comparamos el password del request con el hash guardado en BD usando Hash::check.
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            // 401 = Unauthorized: credenciales inválidas.
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // 4) Token global:
        // Eliminamos TODOS los tokens anteriores del usuario para que solo exista 1 token válido.
        // (Si no hiciéramos esto, cada login crearía otro token y todos quedarían activos).
        $user->tokens()->delete();

        // 5) Creamos un nuevo token personal de Sanctum.
        // createToken devuelve un objeto con plainTextToken (la cadena completa que debes copiar).
        $token = $user->createToken('auth_token')->plainTextToken;

        // 6) Respondemos al cliente con:
        // - access_token: el token en texto plano (solo se ve una vez).
        // - token_type: 'Bearer' indica el formato del header Authorization.
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200); // 200 OK: login exitoso
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); ##elimina el token de acceso actual del usuario que hizo la solicitud
        return response()->json(['message' => 'Cierre de sesión exitoso']); ##devuelve un mensaje de cierre de sesión exitoso
    }

    public function recuperarPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first(); ##busca el usuario por email en la base de datos

        if (!$user) { ##si no encuentra el usuario
            return response()->json(['message' => 'Usuario no encontrado'], 404); ##404 es el codigo de error para no encontrado
        }

        //Logica para pregunta de seguridad y respuesta
        $preguntaValida = $request->pregunta === $user->pregunta;
        $respuestaValida = $request->respuesta === $user->respuesta;

        if (!$preguntaValida || !$respuestaValida) {
            return response()->json(['message' => 'Pregunta o respuesta incorrecta'], 400);
        }

        // Actualizar contraseña
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }
}
