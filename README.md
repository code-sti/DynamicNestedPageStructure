# Dynamic Nested Page Structure

## Project Overview

This project is a demonstration of how to build a dynamic nested page structure using **Laravel 11** and **Vue 3** with the Composition API. The idea behind this project is to provide a flexible, scalable solution for creating and managing nested pages of any depth while supporting dynamic routing and a CRUD interface for managing the pages.

The main goals of the project include:

-   **Dynamic nested page structure**: Pages can be nested to any depth.
-   **Dynamic routing**: Routes are resolved based on the nested structure.
-   **CRUD interface**: Full interface to create, update, delete, and view pages.
-   **Backend & Frontend integration**: Laravel backend handles data persistence, and Vue.js frontend takes care of rendering the pages dynamically.

## Tech Stack

-   **Frontend**: Vue 3 with Composition API
-   **Backend**: Laravel 11+
-   **Database**: MySQL
-   **Authentication**: Laravel Passport for API authentication
-   **Styling**: Bootstrap 5

## Pre-requisites

Before running the project, make sure you have the following installed:

-   **PHP 8.1+**
-   **Composer**
-   **Node.js** (LTS version)
-   **MySQL**
-   **Git**
-   **Laravel 11+**

### Setting Up the Project

1. **Clone the repository**:

    ```bash
    git clone https://github.com/yourusername/DynamicNestedPageStructure.git
    ```

2. **Install Backend Dependencies**:

    Navigate to the backend directory:

    ```bash
    cd backend
    ```

    Then install the PHP dependencies using Composer:

    ```bash
    composer install
    ```

3. **Setup the .env file**:

    Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials.

4. **Run Migrations**:

    Run the migrations to set up the database schema:

    ```bash
    php artisan migrate
    ```

5. **Install Frontend Dependencies**:

    Navigate to the frontend directory:

    ```bash
    cd frontend
    ```

    Install the npm dependencies:

    ```bash
    npm install
    ```

6. **Build the Frontend**:

    Build the Vue.js application:

    ```bash
    npm run dev
    ```

7. **Run the Laravel Development Server**:

    Go back to the backend directory and run the Laravel development server:

    ```bash
    php artisan serve
    ```

    The API will now be available at `http://127.0.0.1:8000`.

### Routes

-   **GET /api/pages**: List all pages.
-   **POST /api/pages**: Create a new page.
-   **PUT /api/pages/{id}**: Update an existing page.
-   **DELETE /api/pages/{id}**: Delete a page.
-   **GET /api/pages/{id}**: Show a specific page (including its children).
-   **GET /{segments}**: Dynamically resolve nested pages based on slugs. Example:
    -   `/page1` -> Displays `Page1`
    -   `/page1/page2` -> Displays `Page2`
    -   `/page1/page2/page1` -> Displays child `Page1`
    -   `/page1/page2/page3/page4` -> Displays `Page4`

### Example Page Structure

A sample nested structure could look like this:

Page1
├── Page2
│ ├── Page1 (Child of Page2)
│ └── Page3 │ ├── Page4 │ └── Page5 Page5(Root-level page)

The URL structure for this would be:

-   `/page1` -> Displays `Page1`
-   `/page1/page2` -> Displays `Page2`
-   `/page1/page2/page1` -> Displays child `Page1`
-   `/page1/page2/page3/page4` -> Displays `Page4`

### Thoughts Behind This Project

The idea for this project was born out of the need for a flexible content management solution. A lot of modern web applications require handling complex content structures that can be nested deeply, and managing these structures can become complicated.

With Laravel providing powerful features like Eloquent ORM and Vue.js providing an intuitive frontend framework, I wanted to combine the two to create a solution that allows for:

1. **Efficient Management of Nested Content**: Whether it's articles, blog posts, or other types of content, this structure allows users to build and manage them dynamically.
2. **Dynamic Routing**: This helps in SEO optimization and in providing an easy-to-understand URL structure for deeply nested pages.
3. **Scalability**: As the project grows, new pages can be added, and existing pages can be edited with ease. The structure allows for any depth of nesting.

The combination of Vue 3's Composition API and Laravel's powerful routing system makes this project easy to extend and maintain while providing an intuitive user experience.

I hope this project can serve as a base for building more complex content management systems and dynamic websites with hierarchical structures.

### Edge Cases

Here are some edge cases that the application accounts for:

1. **Circular References**: Pages should not have circular references. For example, if `Page2` is the child of `Page1`, and `Page1` is also the child of `Page2`, the application should throw an error and prevent the creation or updating of such pages.
2. **Multiple Pages with Same Slug**: Pages with the same slug are distinguished based on their parent-child relationship. Therefore, if multiple pages have the same slug, they can still exist as long as they have different parent IDs.
3. **Empty Slug**: If a page is created with an empty or null slug, it should return a validation error and not be stored in the database.
4. **Invalid Slug Format**: Slugs should be URL-friendly (i.e., lowercase, with hyphens instead of spaces, and alphanumeric). Any invalid slug format should return an error.

### Assumptions

1. **Slug Uniqueness**: While slugs are not globally unique, the combination of slug and parent ID makes each page uniquely identifiable.
2. **Dynamic Routes**: The application assumes that routes are dynamic and will resolve based on the nested structure of pages.
3. **Frontend Rendering**: The Vue.js frontend is designed to render pages dynamically based on the URL structure and the data provided by the backend API.
4. **CRUD Operations**: The backend API is designed to handle CRUD operations, and frontend components will interact with this API for all data manipulations (creating, updating, deleting, and viewing pages).
5. **Parent-Child Relationships**: It is assumed that a page's parent-child relationships are properly maintained and that any operation (like creating or updating a page) respects these relationships.

## Contributing

If you want to contribute to this project, feel free to fork the repository and create a pull request with your improvements or bug fixes. All contributions are welcome!

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
