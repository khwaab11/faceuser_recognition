from django.contrib import admin

# Register your models here.
from .models import Login
from .models import Profile
from .models import Contact

admin.site.register(Login)
admin.site.register(Profile)
admin.site.register(Contact)