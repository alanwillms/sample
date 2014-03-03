/* Replace this file with actual dump of your database */
CREATE TABLE IF NOT EXISTS people (
  id serial NOT NULL,
  first_name varchar(60) NOT NULL,
  last_name varchar(60) NOT NULL,
  country varchar(60) NOT NULL,
  city varchar(60) NOT NULL,
  address text NOT NULL,
  email varchar(255) NOT NULL,
  PRIMARY KEY (id)
);