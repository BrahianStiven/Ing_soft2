const express = require("express");
const db = require("./db");

const app = express();

app.use(express.json());

const TOKEN_SECRETO = 'miclave123';

function requireToken(req, res, next) {
    const token = req.get('Authorization'); //mejor que req.headers['authorization']
    if (token !== `Token ${TOKEN_SECRETO}`) {
        return res.status(403).json({ error: "No autorizado" });
    }
    next();
}

app.get("/health", function (req, res) {
    res.status(200).json({ status: "ok", service: "express" });
});

app.use("/users", requireToken);

app.post("/users", async function (req, res) {
    const { name, email } = req.body;

    const [result] = await db.query(
        "INSERT INTO users (name, email, createdAt) VALUES (?, ?, ?)",
        [name, email, Date.now()]
    );

    res.status(201).json({ id: result.insertId, name, email });
});

app.get("/users", async function (_, res) {
    const [rows] = await db.query("SELECT id, name, email FROM users");
    res.json(rows);
});

app.get("/users/:id", async function (req, res) {
  const [rows] = await db.query(
    "SELECT id, name, email FROM users WHERE id = ?",
    [req.params.id]
  );
  if (rows.length === 0) return res.status(404).json({ error: "No encontrado" });
  res.json(rows[0]);
});

app.put("/users/:id", async function (req, res) {
  const { name, email } = req.body;

  const [result] = await db.query(
    "UPDATE users SET name = ?, email = ? WHERE id = ?",
    [name, email, req.params.id]
  );

  if (result.affectedRows === 0) return res.status(404).json({ error: "No encontrado" });
  res.json({ message: "Actualizado" });
});

app.delete("/users/:id", async function (req, res) {
  const [result] = await db.query("DELETE FROM users WHERE id = ?", [req.params.id]);
  if (result.affectedRows === 0) return res.status(404).json({ error: "No encontrado" });
  res.json({ message: "Eliminado" });
});

app.listen(3000, function () {
    console.log("Servidor en puerto 3000");
});