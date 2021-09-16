# ApiDoc

Use PHP 8 attributes to document your api routes. 

# Installation

First make sure to configure the repository in your composer.json by running:

```bash
composer config repositories.apidoc vcs https://github.com/Wingly-Company/apidoc
```

The install the package by running: 

```bash
composer require wingly/apidoc
```
# Configuration 

You can add basics such as the title, introductory text and base URL information in your apidoc.php config file.

## Title 

To set the HTML `<title>` for the generated docs, use the title key. 
If you leave title empty, the package will infer it from the value of config('app.name').

```php 
'title' => 'My awesome API',
``` 

## Description and introductory text

You can add a description of your API using the description key. This description will be displayed in the docs' "Introduction" section.

The intro_text key is where you'll set the text shown in the "Introduction" section of your docs (after the description).

Markdown and HTML are also supported. 

```php 
'description' => 'Start (and never finish) side projects with this API.',

'intro_text' => <<<INTRO
## This documentation is meant to be used as an overview of all our API routes.

You *can* see details for each request like the method to use the required params the request uri and more.
INTRO
```

## Base URL 

By default, the package will use the current app URL (config('app.url)) as the base URL in your docs. However, you can customize this with the base_url key. For example, setting the base_url to this:

```php 
'base_url' => 'http://api.awesome.come',
```

## Directories 

The directories key specifies the directories to be scanned. Controllers in these directories that have documentation attributes will automatically be scanned and generate your documentation pages.  

```php 
'directories' => [
    app_path('Http/Controllers'),
],
```

## Documentation routes 

The package exposes a `/docs` route. You can change this by setting the route_prefix key. 

```php 
'route_prefix' => '/documentation',
```

# Authorization  

 By default, any user can access the documentation when the current application environment is local. 
 You can define a gate to restrict access in non local environments.  

 ```php 
public function boot()
{
    Gate::define('viewApiDocs', function ($user = null) {
        return in_array($user->email, [
            'dimi@wingly.com'
        ]);
    });
}
 ```

# Usage 

## Generating documentation 

After you've documented your API, you can generate the docs using the `apidoc:generate` Artisan command.
This will:
- Scan you specified directories and extract information about your endpoints
- Transform the extracted information into markdown files 
- Store the files under `storage/apidocs` directory 

It's highly recommended that you include your docs generation as part of your CI/CD.  

## Annotations 

The package provides several annotations that should be put on controller classes and methods. 
These annotations will be used to automatically generate documentation pages for your endpoints.  

### Grouping endpoints  

For easy navigation, endpoints in your API are organized by groups. 
You can add an endpoint to a group by using the Group annotation passing the name of the group.

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\Group('Projects')]
    public function index()
    {
        //
    }
}
```

You can also apply the Group to your controller class grouping all the endpoints in the controller.

```php 
use Wingly\ApiDoc\Attributes as Doc;

#[Doc\Group('Projects')]
class ProjectController extends Controller
{
    public function index()
    {
        //
    }
}
```

### Indicating authentication status

You can use the Authenticated annotation on a method to indicate that the endpoint needs authentication.
A "Requires authentication" badge will be added to that endpoint in the generated documentation.

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\Authenticated]
    public function index()
    {
        //
    }
}
```
Like Group you can use the Authenticated annotation on the controller so you don't have to write it on each method.

### Adding an endpoint  

To add an endpoint to your generated documentation you need to annotate your controller method with the Route annotation 
The Route accepts a description, method and uri parameters.  

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\Route(description: 'Get a list of projects', method: 'get', uri: '/projects')]
    public function index()
    {
        //
    }
}
```

### Adding URL parameters 

To add URL parameters to your endpoint you can use the UrlParameter annotation.  
A section describing the URL parameters will be added to the generated documentation.
The UrlParameter accepts a name, description type and an optional required parameter. 

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    public function show(
        #[Doc\UrlParameter(name: 'id', type: 'integer', description: 'The id of the project', required: true)] $id
    ) {
        //
    }
}
```
You can also apply the annotation at the directly at the method.  

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\UrlParameter(name: 'id', type: 'integer', description: 'The id of the project', required: true)]
    public function show($id) 
    {
        //
    }
}
```

### Adding body parameters 

Similar to URL parameters you can add body parameters to your endpoint. Body parameters can only be applied at the method. A section describing the body parameters will be added to the generated documentation. 

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\BodyParameter(name: 'name', type: 'string', description: 'The name of the project', required: true)]
    public function store(Request $request)
    {
        //
    }
}
```

### Adding responses

You can specify the response types for an endpoint by adding the Response annotation to you method.
A section describing the responses will be added to the generated documentation.
The Response accepts a status (defaults to 200), scenario (defaults to "Success") and example parameters. 

```php 
use Wingly\ApiDoc\Attributes as Doc;

class ProjectController extends Controller
{
    #[Doc\Response()]
    #[Doc\Response(status: 404, scenario: 'Project not found', example: ['message' => 'Not found'])]
    #[Doc\Response(status: 403, scenario: 'Not authorized', example: ['message' => 'Not authorized'])]
    public function show($id) 
    {
        //
    }
}
```

