CREATE TABLE address
(
    id          SERIAL       NOT NULL,
    street      VARCHAR(255) NOT NULL,
    postal_code VARCHAR(255) NOT NULL,
    city        VARCHAR(255) NOT NULL,
    region      VARCHAR(255) NOT NULL,
    country     VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE interest
(
    id   SERIAL       NOT NULL,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX UNIQ_6C3E1A675E237E06 ON interest (name);
CREATE TABLE party
(
    id               SERIAL                         NOT NULL,
    type_id          INT              DEFAULT NULL,
    address_id       INT              DEFAULT NULL,
    created_by_id    INT                            NOT NULL,
    name             VARCHAR(255)                   NOT NULL,
    date             TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    max_participants INT                            NOT NULL,
    is_free          BOOLEAN                        NOT NULL,
    price            DOUBLE PRECISION DEFAULT NULL,
    created_at       TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    updated_at       TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    PRIMARY KEY (id)
);
CREATE INDEX IDX_89954EE0C54C8C93 ON party (type_id);
CREATE UNIQUE INDEX UNIQ_89954EE0F5B7AF75 ON party (address_id, date);
CREATE INDEX IDX_89954EE0B03A8386 ON party (created_by_id);
CREATE TABLE party_user
(
    party_id INT NOT NULL,
    user_id  INT NOT NULL,
    PRIMARY KEY (party_id, user_id)
);
CREATE INDEX IDX_9230179A213C1059 ON party_user (party_id);
CREATE INDEX IDX_9230179AA76ED395 ON party_user (user_id);
CREATE TABLE party_type
(
    id          SERIAL       NOT NULL,
    name        VARCHAR(255) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX UNIQ_937D96FA5E237E06 ON party_type (name);
CREATE TABLE "user"
(
    id             SERIAL                         NOT NULL,
    address_id     INT              DEFAULT NULL,
    email          VARCHAR(180)                   NOT NULL,
    roles          JSON                           NOT NULL,
    password       VARCHAR(255)                   NOT NULL,
    name           VARCHAR(255)                   NOT NULL,
    age            INT              DEFAULT NULL,
    average_rating DOUBLE PRECISION DEFAULT NULL,
    created_at     TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    updated_at     TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX UNIQ_8D93D649F5B7AF75 ON "user" (address_id);
CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email);
CREATE TABLE user_interest
(
    user_id     INT NOT NULL,
    interest_id INT NOT NULL,
    PRIMARY KEY (user_id, interest_id)
);
CREATE INDEX IDX_8CB3FE67A76ED395 ON user_interest (user_id);
CREATE INDEX IDX_8CB3FE675A95FF89 ON user_interest (interest_id);
ALTER TABLE party
    ADD CONSTRAINT FK_89954EE0C54C8C93 FOREIGN KEY (type_id) REFERENCES party_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE party
    ADD CONSTRAINT FK_89954EE0F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE party
    ADD CONSTRAINT FK_89954EE0B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE party_user
    ADD CONSTRAINT FK_9230179A213C1059 FOREIGN KEY (party_id) REFERENCES party (id, created_at) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE party_user
    ADD CONSTRAINT FK_9230179AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE "user"
    ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE user_interest
    ADD CONSTRAINT FK_8CB3FE67A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE user_interest
    ADD CONSTRAINT FK_8CB3FE675A95FF89 FOREIGN KEY (interest_id) REFERENCES interest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

-- INDEXES modifiées à la main dans les migration pour ajouter le lower()
CREATE INDEX idx_address_city ON address (lower(city));
CREATE INDEX idx_party_type_name ON party_type (lower(name));
CREATE INDEX idx_party_date ON party (date);
CREATE INDEX idx_party_is_free ON party (is_free);
