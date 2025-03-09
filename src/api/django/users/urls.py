from django.urls import path, include
from .views import register, login, protected
from django.contrib import admin

urlpatterns = [
    path('register/', register, name='register'),
    path('login/', login, name='login'),
    path('protected/', protected, name='protected'),
    path('admin/', admin.site.urls),
    path('api/', include('users.urls')),
]
