from django.shortcuts import render
from rest_framework import viewsets
from .models import Producto
from .serializers import ProductoSerializer
from rest_framework.decorators import api_view
from rest_framework.response import Response
from .permissions import ValidarTokenPersonalizado
from django.http import JsonResponse

class ProductoViewSet(viewsets.ModelViewSet):
    queryset = Producto.objects.all()
    serializer_class = ProductoSerializer
    permission_classes = [ValidarTokenPersonalizado]

@api_view(['GET'])
def health(request):
    return Response({'status': 'ok', 'service': 'django'})
