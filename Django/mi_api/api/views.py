from django.shortcuts import render
from rest_framework import viewsets
from .models import Producto
from .serializars import ProductoSerializer
from rest_framework.decorators import api_view
from rest_framework.response import Response
from django.http import JsonResponse
# Create your views here.

class ProductoViewSet(viewsets.ModelViewSet):
    queryset = Producto.objects.all()
    serializer_class = ProductoSerializer

@api_view(['GET'])
def health(request):
    return Response({'status': 'ok', 'service': 'django'})
