## Start project

<p>1. Clone this repository</p>
<p>2. Run "composer update" for install dependencies</p>
<p>3. Run "cp .env.example .env"</p>
<p>4. Configure database in .env or <a href="https://github.com/zadochek/apiTask/blob/main/config/database.php">/config/database.php</a></p>
<p>5. Run "php artisan migrate"</p>
<p>You can use php development server for run this project "php artisan serve"</p>
<br/>

## Routes
<p>POST /api/v1/document/ - create new document</p>
<p>GET /api/v1/document/{id} - get specified document</p>
<p>PATCH /api/v1/document/{id} - edit document</p>
<p>POST /api/v1/document/{id}/publish - publish document</p>
<p>GET /api/v1/document/?page=1&perPage=20 - get documents with pagination</p>
