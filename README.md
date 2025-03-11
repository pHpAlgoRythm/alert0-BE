after clonning run composer install command 
create alert04 database then run migration file

API Documentation

Endpoints Table

| Method  | Endpoint               | Description                        | Authentication Required |
|---------|------------------------|------------------------------------|-------------------------|
| **Auth** |
| POST    | `/api/register`         | Registers a new user              | No                      |
| POST    | `/api/login`            | Authenticates a user              | No                      |
| **Emergency Requests** |
| GET     | `/api/requests`         | Retrieves all emergency requests  | Yes                     |
| POST    | `/api/requests`         | Creates a new emergency request   | Yes                     |
| GET     | `/api/requests/{id}`    | Retrieves a specific request by ID | Yes                     |
| PUT     | `/api/requests/{id}`    | Updates an emergency request      | Yes                     |
| PATCH   | `/api/requests/{id}`    | Partially updates an emergency request | Yes               |
| DELETE  | `/api/requests/{id}`    | Deletes an emergency request      | Yes                     |

Authentication

Register a User

Endpoint:** `POST /api/register`
Description: Registers a new user.
Request Body:

json
{
  "name": "string",
  "email": "string (unique, valid email)",
  "password": "string",
  "c_password": "string (same as password)",
  "address": "string",
  "gender": "string",
  "role": "string",
  "status": "string",
  "phone": "string (11 digits)"
}


Expected Response:

json
{
  "token": "string",
  "name": "string",
  "message": "User Registered Successfully."
}


User Login

Endpoint:`POST /api/login`
Description: Authenticates a user.
Request Body:

json
{
  
  "email": "string",
  "password": "string"
}


expected Response:

json
{
    "success": true,
    "data": {
        "token": "string"
    },
    "message": "User Login Successfully"
}


 Emergency Requests

 Get All Requests

Endpoint: `GET /api/requests`
Description: Retrieves a list of all emergency requests.
Expected Response:

json
{
  "data": [
    {
      "success": true,
      "id": "integer",
      "reporter_id": "integer",
      "request_type": "string",
      "request_status": "string",
      "request_date": "string",
      "longitude": "float",
      "latitude": "float"
    }
  ],
  "message": "Requests retrieved successfully."
}


 Create a New Request

Endpoint: `POST /api/requests`
Description: Creates a new emergency request.
Request Body:

json
{
  "reporter_id": "integer (exists in users table)",
  "request_type": "string",
  "request_status": "string (pending, in_progress, completed, rejected)",
  "request_date": "string",
  "longitude": "float",
  "latitude": "float"
}


Expected Response:

json
{
 "success": true,
  "data": { ... },
  "message": "Request created successfully."
}


Get a Specific Request

Endpoint: `GET /api/requests/{id}`
Description: Retrieves a specific request by ID.
Expected Response:

json
{
  "success": true,
  "data": { ... },
  "message": "Request retrieved successfully."
}


Update a Request

Endpoint: `PUT/PATCH /api/requests/{id}`
Description: Updates an existing request.
Request Body: (At least one field required cannot be done if there is not transaction)

json
{
  "reporter_id": "integer (exists in users table)",
  "request_status": "string",
  "request_date": "string",
  "longitude": "float",
  "latitude": "float"
}


Response:

json
{
"success" : true
  "data": { ... },
  "message": "Request updated successfully."
}


Delete a Request

Endpoint:`DELETE /api/requests/{id}`
Description: Deletes an emergency request.
Expected Response:

json
{
  "success": true,
  "data": [],
  "message": "Request deleted successfully."
}


