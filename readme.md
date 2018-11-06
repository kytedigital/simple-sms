
## Endpoints

All need Bearer token: Bearer 123:123 

GET https://penguin-platform.appspot.com/api/customers - Get all store customers
GET https://penguin-platform.appspot.com/api/customers/search?query - Get customers by search query e.g. name

POST https://penguin-platform.appspot.com/api/dispatch - Send an SMS

Payload:

```
{
    "channel": "sms",
    "message" : "test",
	"recipients": [
		{ 
		    "first_name": "Tod",
		    "last_name: "The,",
		    "phone": "61490928809" 
		}
	]
}
```

TODO: 

- Statistics.
- Billing Shit.
- Number.
- 

