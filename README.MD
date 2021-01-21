# Welcome to my Rental application
Website made for Fairwalter company job application 

## Components:
### Rental Object
    - Id
    - Name
    - Address
    - City
    - Country
    - Number of rooms
    - Description
    - Contract (one to Many relationship with entity Contract)
### Contract
    - Id
    - Start date
    - End date
    - Notice period
    - Rent
    - Residents (one to many relationship with entity Person)
    - Contract parties (many to many relationship with Person)
    - Rental object (many to one bi-directional relationship with RentalObject)
### Person
    - Id
    - First name
    - Last name
    - Personal id
    - pType = person type (if the person is an agent or a contractor)
    - Contracts (many to many bi-directional relationship with Contract) 

## Install
    - git clone https://github.com/ketyidody/contract-management.git
    - cd contract-management
    - cp .env.example .env
    - edit .env with your favorite text editor (mainly edit db_user and db_password)
    - composer install
    - yarn encore production (to install yarn visit https://classic.yarnpkg.com/en/docs/install/ or use "npm run build")
    - bin/console doctrine:schema:create
    - bin/console doctrine:fixtures:load
    - symfony server:start
    - visit http://localhost:8000