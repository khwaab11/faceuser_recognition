from django import forms

class LoginForm(forms.Form):
   username = forms.CharField(max_length = 100)
   password = forms.CharField(widget = forms.PasswordInput())
   def clean_message(self):
   	username = self.cleaned_data.get("username")
   	dbuser = Login.objects.filter(email = username)
   	if not dbuser:
   		raise forms.ValidationError("User does not exist in our db!")
   	return username

class ProfileForm(forms.Form):
	site = forms.CharField(max_length=30)
	unique = forms.CharField(max_length=20)
	name = forms.CharField(max_length=30)
	nick = forms.CharField(max_length=50)
	picture = forms.ImageField()
	email = forms.CharField(max_length=50)
	bday = forms.CharField(max_length=12)
	phone_no = forms.CharField(max_length=20)
	motto = forms.CharField(max_length=50)
	hoobies = forms.CharField(max_length=50)
	dream = forms.CharField(max_length=50)
	phone_name = forms.CharField(max_length=50)
	relation = forms.CharField(max_length=50)
	crush = forms.CharField(max_length=20)
	cel_crush = forms.CharField(max_length=50)
	like_in_me = forms.CharField(max_length=100)
	hate_in_me = forms.CharField(max_length=100)
	nick_me = forms.CharField(max_length=20)
	memory = forms.CharField(max_length=1000)
	message = forms.CharField(max_length=1000)

