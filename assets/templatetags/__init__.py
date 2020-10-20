from django import template

register = template.Library()

@register.filter
def to_and(value):
	val=value
	val=val.replace(".","")
	val=val.replace(",","")
	val=val.replace(" ","")
	return val