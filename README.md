<h1 align="center">Super Lead</h1>

This project involves developing a Mini CRM System using Laravel for the backend and Vue.js for the frontend. The system will manage leads and applications, allowing an Admin to assign leads to Counselors, who will then track and process them. The project will incorporate authentication, role-based access control, API endpoints, and a drag-and-drop Kanban board for lead management.
## Project Architecture
This project is a web application that leverages Vue.js for the frontend and Laravel for the backend API. Vue.js provides a dynamic, interactive user experience with a modern, single-page application (SPA) structure, while Laravel powers the backend to handle server-side operations, including data management, authentication, and API services. This structure enables a clear separation between the frontend and backend, making the project scalable, maintainable, and efficient.

## Technology Stack
- Frontend: Vue.js (Vue CLI)
- Backend: Laravel (PHP)
- Database: MySQL
- API Communication: Axios

## Project Setup

### Backend end setup (Development)
- [ Clone laravel Project](https://github.com/rabbialrabbi/bheuni_back)
- Install Dependency by running command composer install in project directory (PHP and [Composer](https://getcomposer.org/download/) required)
- Start MySql Server
- Provide necessary info about MySql Server in .env file
- Run php artisan migrate command for database migration
- Run php artisan db:seed for seed data (!!! Important as few data like Leads, Admin, Counselor only available by seeding!!! )
- Run php artisan key:generate for app key
- Run php artisan serve --port=8002 for server (By default front end will call in this port. for custom need to change in frontend .env file)

### Front end setup (Development)
- [ Clone vue Project](https://github.com/rabbialrabbi/bheuni_front)
- Install Dependency by running command npm install in project directory (Node.js and npm required)
- Run npm run dev for dev server
- Enjoy

!!! Please contact in rabbialrabbi@gmail or +8801723659050 for any support !!!

## Acknowledgments
- For Admin Panel [berrydashboard.io](https://berrydashboard.io/vue/free/) UI design has been taken
- ChatGPT
- Google
- Stackoverflow
