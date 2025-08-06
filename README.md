# Company-Category

Company-Category is a laravel project which consists details of company based on the category.

## Installation

```bash
git clone https://github.com/brishti98/company-assigment.git
```
Set up your .env along wit API-KEY and run the below commands:
```
composer install
php artisan config:clear
php artisan migrate
```

## API Reference

#### Header format:
| Authorization | API-KEY | BA673A414C3B44C98478BB5CF10A0F832574090C |
| :-------- | :------- | :------------------------- |

### Company Category API

#### List all categories with pagination(10 records) in API

```http
  GET api/category?page=
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page`    | `integer`| **Required**. Current page number |

#### Create category API

```http
  POST /api/category
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`   | `string` | **Required**. Category title |

#### Update category API

```http
  PUT /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To update the category data |
| `title`   | `string` | **Required**. Category title |

#### Get individual details of the category and in relation get multiple companies

```http
  GET /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To fetch category data |

#### Delete category API

```http
  DELETE /api/category/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To delete category data |

#### Get Result of keyword

```http
  GET /api/category?page=&keyword=
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `keyword`   | `string` | **Required**. To search the category according to the keyword |
| `page`   | `integer` | *Required**. Current page number |


### Company API

#### List all company with pagination(10 records) in API and also send category details if `category_id` is selected

```http
  GET api/company?page=
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page`    | `integer`| **Required**. Current page number |

#### Create company API. And also insert `category_id` if selected. Image upload should be supported if uploaded

```http
  POST /api/company
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`   | `string` | **Required**. Company title |
| `category_id`   | `integer` | **Optional**. Category title id |
| `image`   | `file` | **Optional**. Uploaded image |
| `description`   | `text` | **Optional**. Company descritpion |

#### Update company API. And also update `category_id` if selected. Image upload update should be done if uploaded a new image.

```http
  PUT /api/company/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To update the category data |
| `title`   | `string` | **Required**. Company title |
| `category_id`   | `integer` | **Optional**. Category title id |
| `image`   | `file` | **Optional**. Uploaded image |
| `description`   | `text` | **Optional**. Company descritpion |

#### Get individual details of the company. And also send category details if `category_id` is selected.

```http
  GET /api/company/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To fetch company data |

#### Delete company api. The image should be deleted if there is any.

```http
  DELETE /api/company/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`   | `integer` | **Required**. To delete category data |
