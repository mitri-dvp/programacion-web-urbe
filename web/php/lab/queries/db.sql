DROP TABLE IF EXISTS users, roles CASCADE;

CREATE TABLE roles
(
    id smallint NOT NULL,
    name character varying(50) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO roles (id, name)
VALUES
  (1, 'doctor'),
  (2, 'nurse');


CREATE TABLE users
(
  id integer NOT NULL,
  name character varying(100) NOT NULL,
  email character varying(100) NOT NULL,
  password character varying(100) NOT NULL,
  role_id smallint NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE patients
(
  id integer NOT NULL,
  name character varying(100) NOT NULL,
  password character varying(100) NOT NULL,
  role_id smallint NOT NULL,
  PRIMARY KEY (id)
);
