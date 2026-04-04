# deve_blog — Setup Notes

Database and API credentials are stored in `.env` (not committed to git).
See `.env.example` for the required variables.

---

## Phase 7 — LinkedIn Access Token (Steps)

**1. Create a LinkedIn App:**
- Go to https://www.linkedin.com/developers/apps → **Create app**
- Add your company page
- Request products: **Share on LinkedIn** + **Sign In with LinkedIn**

**2. Get your token via OAuth:**
```
https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=YOUR_CLIENT_ID&redirect_uri=https://develop-it.tech/blog/linkedin-callback.php&scope=openid%20profile%20w_member_social
```

**3. Exchange code for token** via `linkedin-callback.php`

Credentials (client_id, client_secret, page_id) are in `.env`.
