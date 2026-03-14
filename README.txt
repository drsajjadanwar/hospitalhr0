An open-source project to promote transparent hiring in the healthcare sector.

[Public Visitors & Candidates]
                  │
                  ▼
  ┌───────────────────────────────────────────────┐
  │           PUBLIC PORTAL (Frontend)            │
  │                                               │
  │ ➔ index.php (Landing, Benefits, Routing)      │
  │ ➔ contact.php & complaints.php (Information)  │
  │ ➔ vacancies.php (Displays 'Open' roles)       │
  │ ➔ apply.php (Data & Document Uploads)         │
  │ ➔ subscribe.php (Mailing List Opt-in)         │
  └───────────────────────┬───────────────────────┘
                          │
                     Reads & Writes
                          │
            ┌─────────────▼─────────────┐
            │       MYSQL DATABASE      │
            │   (via includes/db.php)   │
            │                           │
            │  • vacancies              │
            │  • subscribers            │
            │  • admin                  │
            └─────────────▲─────────────┘
                          │
                     Reads & Updates
                          │
  ┌───────────────────────┴───────────────────────┐
  │           ADMIN PANEL (Management)            │
  │                                               │
  │ ➔ login.php / logout.php (Session Auth)       │
  │ ➔ admin.php (Dashboard & Control)             │
  │    ↳ Toggles status: Open / Closed / On Hold  │
  └───────────────────────▲───────────────────────┘
                          │
                          │
             [Authorised Management]

=======================================================
[BACKGROUND SERVICES] ➔ composer.json (PHPMailer v6.9)
=======================================================

1. The Public Portal (Candidate-Facing)
Information & Routing: The entry points (index.php, contact.php, complaints.php) serve static information, clinic benefits, and direct users toward the career portal or mailing list.
Job Listings (vacancies.php): This dynamically queries the database for roles specifically marked as Open and displays them to the public.
Applications (apply.php): When a candidate clicks 'Apply' on an open role, they are taken here. It validates their details and handles the secure upload of their application documents (restricted to PDF or JPG formats under 10MB) before presumably alerting you or saving the application.
Alerts (subscribe.php): Visitors who want to be notified of future roles can input their email address, which is safely inserted into the subscribers table.

2. The Admin Panel (Management-Facing)
Security (login.php & logout.php): The administrative backend is protected by a password verification system that checks credentials against the admin table in your database.
Vacancy Control (admin.php): Once authenticated, management can view all roles. Submitting changes here runs UPDATE queries on the database, allowing you to instantly change a role's status to Open, Closed, or On Hold. Changing a role to 'Open' makes it instantly appear on the public vacancies.php page.

3. Core Infrastructure
Database Link (includes/db.php): The central nervous system of the app. Every dynamic page relies on this connection to pull vacancies, verify admins, or save subscribers.
Mailing (composer.json): Your infrastructure requires PHPMailer to function. This allows the system to send out outbound communications—such as auto-replies to candidates, or job alerts to your list of subscribers.