````markdown
# Dynamic Nested Page Structure Project

This project provides a dynamic nested page structure API using Laravel as the backend and Vue.js for the frontend. Pages can be nested infinitely, and dynamic routing is used to resolve pages based on their position in the hierarchy. The project also includes CRUD functionality for managing pages.

## Tech Stack

-   **Backend**: Laravel 11+
-   **Frontend**: Vue 3 with Composition API
-   **Database**: MySQL (or any other database supported by Laravel)
-   **Testing**: PHPUnit for backend tests, Jest (or similar) for frontend tests

## Pre-Requisites

Before starting the project, ensure that you have the following installed on your machine:

-   **PHP (>=8.0)**
-   **Composer** (for PHP dependencies)
-   **Node.js** (>=14.x)
-   **NPM** (for frontend dependencies)
-   **MySQL** (or any compatible database)

## Installation

Follow these steps to set up the project:

### 1. Clone the Repository

```bash
git clone https://github.com/code-sti/DynamicNestedPageStructure.git
cd dynamic-nested-pages
```
````

### 2. Install Backend Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

### 3. Install Frontend Dependencies

Install the frontend dependencies using NPM:

```bash
npm install
```

### 4. Set up Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Edit the `.env` file to configure the database and other settings.

### 5. Migrate the Database

Run the following command to migrate the database schema:

```bash
php artisan migrate
```

### 6. Seed the Database (Optional)

You can seed the database with sample data:

```bash
php artisan db:seed
```

### 7. Serve the Application

Start the Laravel server:

```bash
php artisan serve
```

Start the Vue frontend development server (if applicable):

```bash
npm run dev
```

Now your application should be running locally at `http://localhost:8000`.

## API Routes

Here are the key routes available for the project:

### 1. **List all pages**

-   **Route**: `GET /api/pages`
-   **Description**: Fetch all pages from the database.
-   **Response**: List of pages with `id`, `title`, `slug`, and `parent_id`.

### 2. **Get a specific page by ID**

-   **Route**: `GET /api/pages/{id}`
-   **Description**: Fetch a specific page by its `id`.
-   **Response**: A page object with `id`, `title`, `slug`, `content`, and `parent_id`.

### 3. **Create a new page**

-   **Route**: `POST /api/pages`
-   **Description**: Create a new page with the specified data.
-   **Request Body**:
    ```json
    {
        "title": "Page Title",
        "slug": "page-slug",
        "content": "Page content here.",
        "parent_id": null
    }
    ```
-   **Response**: The newly created page object.

### 4. **Update a page**

-   **Route**: `PUT /api/pages/{id}`
-   **Description**: Update an existing page by its `id`.
-   **Request Body**:
    ```json
    {
        "title": "Updated Title",
        "slug": "updated-slug",
        "content": "Updated page content."
    }
    ```
-   **Response**: The updated page object.

### 5. **Delete a page**

-   **Route**: `DELETE /api/pages/{id}`
-   **Description**: Delete a page by its `id`.
-   **Response**: A success message confirming the deletion.

### 6. **Resolve Nested Page (Dynamic Routing)**

-   **Route**: `GET /{segments}`
-   **Description**: Resolves pages dynamically based on the hierarchical path.
-   **Examples**:
    -   `GET /page1/page2` — Resolves to Page2 which is a child of Page1.
    -   `GET /page1/page2/page1` — Resolves to a child Page1 under Page2.
    -   `GET /page1/page3/page5` — Resolves to child Page5 under Page3.

If two pages have the same slug at different levels, they are distinguished based on their position in the hierarchy.

## Frontend Setup

1. **Install Vue.js**: If you're using Vue CLI, set up a new Vue project. You can use Vue 3 with Composition API for the frontend.
2. **Axios**: Use Axios to make HTTP requests to the API.
3. **Dynamic Routing**: For resolving pages dynamically, use Vue Router. Here's an example:

### Sample Vue Component to Fetch and Display Pages:

```vue
<template>
    <div>
        <h1>{{ page.title }}</h1>
        <p>{{ page.content }}</p>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    setup() {
        const page = ref(null);
        const slugPath = window.location.pathname.substring(1); // Get the path after the domain

        const fetchPage = async () => {
            try {
                const response = await axios.get(`/api/${slugPath}`);
                page.value = response.data;
            } catch (error) {
                console.error("Error fetching page:", error);
            }
        };

        onMounted(fetchPage);

        return { page };
    },
};
</script>
```

### Vue Router Configuration:

```javascript
const routes = [
    {
        path: "/:slugPath",
        name: "page",
        component: PageComponent, // The Vue component you created
        props: true,
    },
];
```

## Running Tests

To run the tests for this project:

1. **Backend Tests (PHPUnit)**:
   Run the following command to execute backend tests:

    ```bash
    php artisan test
    ```

2. **Frontend Tests (Jest)**:
   If using Jest for frontend testing, run:

    ```bash
    npm run test
    ```

### Test Coverage

-   **Create Page Test**: Ensures pages can be created with valid data.
-   **Resolve Nested Pages Test**: Ensures that nested pages are resolved based on the dynamic route.
-   **Update Page Test**: Ensures pages can be updated and the changes are reflected.
-   **Validation Errors Test**: Ensures that proper validation errors are returned when submitting invalid data.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```

### Key Sections:

1. **Tech Stack**: Lists the technologies used in the project.
2. **Pre-Requisites**: Provides installation requirements for PHP, Composer, Node.js, etc.
3. **Installation**: Step-by-step guide to set up the project.
4. **API Routes**: Details the available API routes with examples and descriptions.
5. **Frontend Setup**: Basic guide to set up the frontend with Vue.js and Axios.
6. **Running Tests**: Instructions to run both backend and frontend tests.
7. **License**: Indicates that the project is licensed under MIT.

This `README.md` file will give users clear instructions on how to set up and interact with the project.
```
