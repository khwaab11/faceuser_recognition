from django.db import models

# Create your models here.

class Login(models.Model):
	name = models.CharField(max_length=30,unique=True)
	email = models.CharField(max_length=50)
	password = models.CharField(max_length=50)
	unique = models.CharField(max_length=20,default='SOME STRING',unique=True)

	def __str__(self):
		return self.name


class Profile(models.Model):
	owner = models.CharField(max_length=30)
	unique = models.CharField(max_length=20)
	name = models.CharField(max_length=30)
	nick = models.CharField(max_length=50)
	picture = models.ImageField(upload_to = 'pictures')
	email = models.CharField(max_length=50)
	bday = models.CharField(max_length=20, default="Didnt fill")
	phone_no = models.CharField(max_length=15, default="Didnt fill")
	motto = models.CharField(max_length=50)
	hoobies = models.CharField(max_length=50)
	dream = models.CharField(max_length=50)
	phone_name = models.CharField(max_length=50)
	relation = models.CharField(max_length=50)
	crush = models.CharField(max_length=20)
	cel_crush = models.CharField(max_length=50, default="Didnt fill")
	like_in_me = models.CharField(max_length=100)
	hate_in_me = models.CharField(max_length=100)
	nick_me = models.CharField(max_length=20)
	memory = models.CharField(max_length=1000)
	message = models.TextField()
	def __str__(self):
		return self.name

class Contact(models.Model):
	name = models.CharField(max_length=10)
	subject = models.CharField(max_length=25)
	email = models.CharField(max_length=30)
	message = models.TextField()