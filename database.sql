CREATE TABLE product_type (
  id BIGINT,
  description VARCHAR NOT NULL,
  tax_percentage NUMERIC NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE product (
  id BIGINT,
  product_type_id BIGINT  NOT NULL ,
  description VARCHAR NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (product_type_id) REFERENCES product_type(id)
);

CREATE TABLE sales (
  id BIGINT,
  description VARCHAR NOT NULL,
  products JSON NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
