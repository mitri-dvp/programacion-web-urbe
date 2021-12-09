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
  doctor_id integer NOT NULL,
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

INSERT INTO users (id, name, email, password, role_id)
VALUES
(123, 'Jose', 'jose@gmail.com', '$2y$10$D18xiIDTRdv2JxBKKVSZDeCzM31F/BvQaNSS1McX5KZ2hYfMJJcje', 1),
(456, 'María', 'maría@gmail.com', '$2y$10$HvljK/Cz4mUgGMeXPm7JSOucaGU3gBw/BNd.kPtDAQx7fqx2dkmSa', 2);

INSERT INTO patients (id, name, email)
VALUES
  (12345, 'Juan', 'juan.medina@urbe.edu.ve'),
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

INSERT INTO exams (id, doctor_id, patient_id, type_id, state_id, results)
VALUES
  (1, 123, 12345, 1, 1, 'Hematíes = 4.5-5.9 millones/mm3
Hemoglobina (Hb) = 13,5-17,5 g/dl
Hematocrito (Hto) = 41-53%
VCM (volumen corpuscular medio) = 88-100 fl
HCM (hemoglobina corpuscular media) = 27-33 pc
Linfocitos = 1.300-4.000 /mL
Leucocitos = 4.500-11.500 mL
Neutrófilos = 2.000-7.500 /mL
Eosinófilos = 50-500 /mL
Plaquetas = 150000-400000/ mm3
VSG (velocidad de sedimentación) = 0-10 mm/h');
