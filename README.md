# courseProj Setup

## 1. Get the Latest Version

1. Go to GitHub.
2. Switch to the branch:

pagination-and-sorting

3. Click:

Code → Download ZIP

4. Extract the ZIP and replace your project files.

---

## 2. Set Up JWT Tables

1. Open phpMyAdmin.
2. Import `users.sql` from Unit 3 Practice 1.
3. Make sure the following tables exist:

* users
* roles

---

## 3. Install Required Packages

Open the PhpStorm terminal and run:

```bash
composer install
composer dump-autoload
```

---

## 4. Start XAMPP

Start:

* Apache
* MySQL

---

## 5. Create a User

In Postman:

**POST**

```text
{{base_url}}/users
```

Body:

```json
{
  "name":"Test User",
  "username":"testuser",
  "email":"test@test.com",
  "password":"password",
  "role":1
}
```

---

## 6. Generate a JWT Token

**POST**

```text
{{base_url}}/users/authJWT
```

Body:

```json
{
  "username":"testuser",
  "password":"password"
}
```

Copy the token that is returned.

---

## 7. Test JWT Authentication

**GET**

```text
{{base_url}}/jwt-protected/guests
```

Authorization Type:

```text
Bearer Token
```

Paste the token from Step 6.

If guest data is returned, JWT authentication is working.

---

## Features Included

### Lab 3

* Create
* Update
* Delete
* Search
* Sorting
* Pagination

### Lab 4

* Users
* Password Hashing
* JWT Authentication
* Protected Routes

---

## If Something Doesn't Work

Run:

```bash
composer dump-autoload
```

If packages are missing:

```bash
composer install
```
