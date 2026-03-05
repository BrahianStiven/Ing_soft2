from locust import HttpUser, task

class SimpleCrudUser(HttpUser):
    @task
    def get_product(self):
        self.client.get("/api/users")

    @task
    def create_product(self):
        data ={
            "name": "Pepe",
            "email": "pepe@locustprueba.com",
            "pregunta": "Color",
            "respuesta": "verde",
            "password": "unodostres",
        }
        self.client.post("/api/users", json=data)
    
    @task 
    def update_product_put(self):
        data ={
            "name": "ana",
            "email": "ana@locustprueba.com",
            "password": "unodostrescuatro",
        }
        self.client.put("/api/users/3", json=data)

    # @task
    # def delete_product(self):
    #     self.client.delete("/products/10")

