ABM con PHP Symfony con relaciones sql manytomany
Este ejemplo fue creado para un examén técnico
raulcasanova@yahoo.com

#### Clona el proyecto e instala las dependencias:

```
git clone https://github.com/raulin64/easyadmimanytomany.git


cd SymfonyMany

composer install

#### Crear base de datos (si aún no se ha creado):
`symfony console doctrine:database:create`

#### Doctrine migrate schema:
`symfony console doctrine:migrations:migrate`

#### If using Adminer you could manage created DB:
http://localhost:8000/film/

#### Start 
`symfony server:start`




