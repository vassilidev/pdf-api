# PDF API Installation Guide

This guide will walk you through the steps to install and set up the PDF API Laravel application.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- [PHP](https://www.php.net/) (>= 8.1)
- [Composer](https://getcomposer.org/)

## Installation

1. Clone the repository:

    ```bash
    git clone git@github.com:vassilidev/pdf-api.git
    ```

2. Navigate to the project directory:

    ```bash
    cd pdf-api
    ```

3. Copy the example environment file:

    ```bash
    cp .env.example .env
    ```

4. Run the deployment script:

    ```bash
    sh deploy.sh
    ```

5. Generate App Key

    ```bash
    php artisan key:generate
    ```

## Configuration

After completing the installation steps above, make sure to configure your `.env` file with the necessary settings such as database connections, API keys, and any other required configurations.

## Usage

Once the installation and configuration are complete, you can start using the PDF API Laravel application as needed.

## API Documentation

Below are the endpoints provided by the PDF API along with their descriptions:

### Get All Contracts

- **Method**: GET
- **Endpoint**: `http://localhost/api/contracts`

### Get Single Contract

- **Method**: GET
- **Endpoint**: `http://localhost/api/contracts/{contract_id}`

### Stream PDF Contract

- **Method**: GET
- **Endpoint**: `http://localhost/api/stream/{contract_id}`

### Delete Contract

- **Method**: DELETE
- **Endpoint**: `http://localhost/api/stream/{contract_id}`

### Update Contract

- **Method**: PUT
- **Endpoint**: `http://localhost/api/contracts/{contract_id}`
- **Request Body**:
  ```json
  {
      "name": "New Name",
      "content": "<h1>Test</h1>",
      "author": "Test user"
  }

### Store Contract

- **Method**: POST
- **Endpoint**: `http://localhost/api/contracts`
- **Request Body**:
  ```json
  {
      "name": "New Name",
      "content": "<h1>Test</h1>",
      "author": "Test user"
  }