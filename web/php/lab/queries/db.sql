DROP TABLE IF EXISTS users, roles, patients, exam_types, exam_states, exams CASCADE;

CREATE TABLE roles
(
  id smallint NOT NULL,
  name character varying(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users
(
  id integer NOT NULL,
  name character varying(100) NOT NULL,
  email character varying(100) NOT NULL,
  password character varying(100) NOT NULL,
  role_id smallint NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE patients
(
  id integer NOT NULL,
  name character varying(100) NOT NULL,
  email character varying(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE exam_types
(
  id smallint NOT NULL,
  name character varying(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE exam_states
(
  id smallint NOT NULL,
  name character varying(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE exams
(
  id serial NOT NULL,
  patient_id integer NOT NULL,
  type_id smallint NOT NULL,
  state_id smallint NOT NULL,
  results text NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (type_id) REFERENCES exam_types(id),
  FOREIGN KEY (state_id) REFERENCES exam_states(id)
);

INSERT INTO roles (id, name)
VALUES
  (1, 'doctor'),
  (2, 'nurse');

INSERT INTO patients (id, name, email)
VALUES
  (123, 'Jose', 'jose@gmail.com'),
  (456, 'María', 'maría@gmail.com'),
  (789, 'Alejandra', 'alejandra@gmail.com'),
  (987, 'Pedro', 'pedro@gmail.com'),
  (654, 'Alberto', 'alberto@gmail.com'),
  (321, 'Beatriz', 'beatriz@gmail.com');

INSERT INTO exam_types (id, name)
VALUES
  (1, 'Examen de Sangre'),
  (2, 'Perfil Tiroidero'),
  (3, 'Examen de Glucosa'),
  (4, 'Examen Rectal'),
  (5, 'Colesterol Total'),
  (6, 'Colonoscopia'),
  (7, 'Audiograma'),
  (8, 'Presión Arterial'),
  (9, 'Densitometría Ósea'),
  (10, 'Examen Ocular');

INSERT INTO exam_states (id, name)
VALUES
  (1, 'pendiente'),
  (2, 'listo');
