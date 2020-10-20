from django.shortcuts import render,redirect

# Create your views here.
from django.http import HttpResponse, JsonResponse
from .models import Login
from .models import Profile
from .models import Contact
from django.views.decorators.csrf import csrf_exempt
from .forms import LoginForm
from .forms import ProfileForm
import random
from django.contrib import messages
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login
from django.contrib.auth import logout as django_logout
from django.contrib.auth.decorators import login_required
from django.views.decorators.cache import cache_control

def gen_uniqueid():
	captial = chr(random.randint(65, 90))
	lower = chr(random.randint(97, 122))
	# l=['@','#','$','&']
	# special=random.choice(l)
	digits = random.randint(10000, 99999)
	digit = str(digits)
	result = captial + lower + digit
	return result


# Create your views here.
def open_homepage(request):
	return render(request, "index.html")

@cache_control(no_cache=True, must_revalidate=True, no_store=True)
def loginpage(request):
	if request.user.is_authenticated:
		return redirect("/service-page.html")
	return render(request, "login.html")


def save(request):
	if (request.session['is_saved'] == False):
		print("came to valid")
		profile = Profile()
		profile.owner = request.POST["owner"]
		profile.unique = request.POST["id1"]
		name = request.POST["name"]
		profile.name = name.title()
		nick = request.POST["nick"]
		profile.nick=nick.title()
		profile.picture = request.FILES["picture"]
		profile.email = request.POST["email"]
		profile.bday = request.POST["bday"]
		profile.phone_no = request.POST["phone_no"] 
		motto = request.POST["motto"]
		profile.motto = motto.title()
		hoobies = request.POST["hoobies"]
		profile.hoobies = hoobies.title()
		dream = request.POST["dream"]
		profile.dream = dream.title()
		phone_name = request.POST["phone_name"]
		profile.phone_name = phone_name.title()
		relation = request.POST["relation"]
		profile.relation = relation.title()
		crush = request.POST["crush"]
		profile.crush =crush.title()
		cel_crush = request.POST["cel_crush"]
		profile.cel_crush = cel_crush.title()
		like_in_me = request.POST["like"]
		profile.like_in_me = like_in_me.title()
		hate_in_me = request.POST["hate"]
		profile.hate_in_me = hate_in_me.title()
		nick_me = request.POST["nice_me"]
		profile.nick_me = nick_me.title()
		memory = request.POST["memory"]
		profile.memory = memory.title()
		message = request.POST["message"]
		profile.message = message.title()
		profile.save()
		request.session['is_saved']=True
		request.session['name'] = name
		return redirect('/share')
	else:
		messages.success(request,"You have already saved the entry")
		return redirect('/share')

@login_required(login_url='/login.html')
def delete(request,owner,friend_name):
	isinstance1 = Profile.objects.get(owner=owner,name=friend_name)
	isinstance1.delete()
	return redirect("/service-page.html")

@csrf_exempt
def login2(request):
	if request.user.is_authenticated:
		return redirect("/service-page.html")
	
	if request.method == "POST":
		username = request.POST["username"]
		password = request.POST["password"]

		user = authenticate(username=username.lower(),password=password)

		if user is not None:
			login(request, user)
			request.session['user_id'] = username.lower()
			request.session['is_logged'] = True
			print(username)
			print(username.lower())
			user1 = Login.objects.get(name=username.lower())
			Friends = Profile.objects.filter(owner=username.lower(),unique=user1.unique)
			return redirect("/service-page.html")
		else:
			messages.error(request,"Invaild Credentials, Please try again")
			return render(request,"login.html")
	else:
		return HttpResponse("Only POST Methods are allowed baby")
	return HttpResponse("Wrong password")

@login_required(login_url='/login.html')
def service(request):
	user2 = request.user
	user1 = Login.objects.get(name=user2)
	Friends = Profile.objects.filter(owner=user2)
	messages.success(request,"You Have Successfully Logged In, Add your friends By clicking on add friends in the nav bar")
	return render(request,"service-page.html",{'name':request.user , 'friends':Friends ,'unique':user1.unique  })

def add(request, name, id1):
	site = Login.objects.filter(unique=id1)
	if len(site) == 0:
		return HttpResponse("Wrong Share")
	if site[0].name == name:
		content = {}
		content["owner"] = name
		content["id1"] = id1
		request.session['is_saved'] = False
		return render(request, "add.html", content)
	return HttpResponse("Wrong")


def register(request):
	return render(request, "registration.html")


def register_success(request):
	name = request.POST["name"]
	password = request.POST["password"]
	email = request.POST["email"]
	uniqueid = gen_uniqueid()
	# Chech For erroneous Inputs
	
	# Create User
	if ' ' in name:
		messages.error(request,"Book Name must be of single word(Should'nt have spaces)")
		return redirect('/registration.html')
	site = User.objects.filter(username = name.lower())
	print(site)
	if (len(site)==0):
		myuser = User.objects.create_user(name.lower(), email, password)
		myuser.save()
		login = Login(name=name.lower(), email=email, password=password, unique=uniqueid)
		login.save()
		messages.success(request, "Your account has been created! Now You can go to login and create your Slam Book")
		return redirect('/login.html')
	else:
		messages.error(request,"Book name must be unique all others.Book name already exists , try using some alpha numeric names ")
		return redirect('/registration.html')

@cache_control(no_cache=True, must_revalidate=True, no_store=True)
def logout(request):
	django_logout(request)
	return redirect('login.html')
	
def contactus(request):
	return render(request,"contact-us.html")

@login_required(login_url='/login.html')
def change_password(request):
	return render(request,"change_password.html")

def about(request):
	return render(request,"about-us.html")

@login_required(login_url='/login.html')
def change(request):
	if request.method == 'POST':
		current = request.POST['current']
		new_pass = request.POST['new_pass']
		re_new = request.POST['re_new']
		user1 = Login.objects.get(name=request.user)
		if (current == user1.password):
			if (new_pass == re_new):
				u = User.objects.get(username=request.user)
				django_logout(request)
				u.set_password(new_pass)
				u.save()
				user1.password = new_pass
				user1.save()
				messages.success(request,"Password Has been Successfully Changed")
				return redirect('/login.html')
			else:
				messages.error(request,"New Password and Re - Enter New Password Doesn't Match")
				return redirect('/change_pass')
		else:
			messages.error(request,"Present Password is incorrectly typed, Please Check Again")
			return redirect('/change_pass')
	else:
		return HttpResponse("Only POST requests are accepted Baby")


def share(request):
		if request.session['name']:
			name=request.session['name']
			del request.session['name']
			return render(request,'share.html',{'name':name})
			

def share2friends(request):
	return render(request,'share.html')

def contact(request):
	if request.method == 'POST':
		name = request.POST["name"]
		subject = request.POST["subject"]
		email = request.POST["email"]
		message = request.POST["message"]
		con = Contact(name=name,subject=subject,email=email,message=message)
		con.save()
		messages.success(request,"Thank you for contacting us, We will get to you as soon as possible")
		return redirect("contact-us.html")