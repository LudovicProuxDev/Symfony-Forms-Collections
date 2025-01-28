# Symfony-Forms-Collections

This is a project to embed forms with collections.

A form can add at the same time a parent entity with child entities.

In the project, we insert a Company with its Teams in the database.

To create these forms, we need to use the main ressource from Symfony, [Embed a Collection of Forms](https://symfony.com/doc/current/form/form_collections.html).

Get the dependencies and follow instructions:

1. Create database in MySQL
```bash
symfony console doctrine:database:create
```

2. Execute migration
```bash
symfony console doctrine:migrations:migrate
```

3. Run the app
```bash
symfony server:start
```

Now, we can test the embed forms with collections.