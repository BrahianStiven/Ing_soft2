from locust import HttpUser, task

class SimpleCrudUser(HttpUser):
    @task
    def get_product(self):
        self.client.get("/products/10")

    @task
    def create_product(self):
        data ={
            "title": "Nuevo producto",
            "price": 60.0,
            "description": "Producto creado en test",
            "image": "https://i.pravatar.cc",
            "category": "electronics"
        }
        self.client.post("/products", json=data)
    
    @task 
    def update_product_put(self):
        data ={
            "title": "Producto atualizado Put",
            "price": 70.0,
            "description": "actualizacion completa PUT",
            "image": "https://i.pravatar.cc",
            "category": "electronics"
        }
        self.client.put("/products/10", json=data)

    @task
    def delete_product(self):
        self.client.delete("/products/10")

