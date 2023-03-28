CREATE TABLE product_types (
  id SERIAL PRIMARY KEY,
  description VARCHAR NOT NULL,
  tax_percentage NUMERIC NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  product_type_id BIGINT  NOT NULL ,
  name VARCHAR NOT NULL,
  price NUMERIC NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_type_id) REFERENCES product_types(id)
);

CREATE TABLE sales (
  id SERIAL PRIMARY KEY,
  description VARCHAR NOT NULL,
  products JSON NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);