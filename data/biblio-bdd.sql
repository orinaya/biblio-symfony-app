-- Adminer 5.2.1 PostgreSQL 16.8 dump

DROP FUNCTION IF EXISTS "notify_messenger_messages";;
CREATE FUNCTION "notify_messenger_messages" () RETURNS trigger LANGUAGE plpgsql AS '
        BEGIN
            PERFORM pg_notify(''messenger_messages'', NEW.queue_name::text);
            RETURN NEW;
        END;
    ';

DROP TABLE IF EXISTS "author";
DROP SEQUENCE IF EXISTS author_id_seq;
CREATE SEQUENCE author_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."author" (
    "id" integer DEFAULT nextval('author_id_seq') NOT NULL,
    "firstname" character varying(255),
    "lastname" character varying(255) NOT NULL,
    "birthday" date,
    "image" character varying(255),
    CONSTRAINT "author_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "author" ("id", "firstname", "lastname", "birthday", "image") VALUES
(1,	'Antoine',	'De Saint-Exupéry',	'1900-06-29',	'680e3cedc51c3.jpg'),
(2,	'Hirohiko',	'Araki',	'1960-06-07',	'68114b12395ea.jpg'),
(3,	'J. R. R.',	'Tolkien',	'1892-01-03',	NULL),
(4,	'Agatha',	'Christie',	'1890-09-15',	NULL),
(5,	'Jane',	'Austen',	'1775-12-16',	NULL);

DROP TABLE IF EXISTS "author_book";
CREATE TABLE "public"."author_book" (
    "author_id" integer NOT NULL,
    "book_id" integer NOT NULL,
    CONSTRAINT "author_book_pkey" PRIMARY KEY ("author_id", "book_id")
) WITH (oids = false);

CREATE INDEX idx_2f0a2bee16a2b381 ON public.author_book USING btree (book_id);

CREATE INDEX idx_2f0a2beef675f31b ON public.author_book USING btree (author_id);

INSERT INTO "author_book" ("author_id", "book_id") VALUES
(1,	5),
(2,	7);

DROP TABLE IF EXISTS "book";
DROP SEQUENCE IF EXISTS book_id_seq;
CREATE SEQUENCE book_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."book" (
    "id" integer DEFAULT nextval('book_id_seq') NOT NULL,
    "title" character varying(255) NOT NULL,
    "desciption" text,
    "image" character varying(255),
    "publication_year" integer,
    "isbn" character varying(20) NOT NULL,
    CONSTRAINT "book_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE UNIQUE INDEX uniq_cbe5a331cc1cf4e6 ON public.book USING btree (isbn);

INSERT INTO "book" ("id", "title", "desciption", "image", "publication_year", "isbn") VALUES
(7,	'test',	'iuh',	'681030b18540a.jpg',	1620,	'2-07-054193-0'),
(5,	'Le petit Prince',	'On ne voit bien qu''avec le cœur, l''essentiel est invisible pour les yeux.',	'68101c2d44ae6.jpg',	1946,	'2-07-054193-2'),
(1,	'Citadelle',	'Description',	'681149af26b8b.jpg',	2013,	'ISBN'),
(2,	'Jojo''s Bizarre Adventure - Stardust crusaders Tome 01 : Jojo''s - Stardust Crusaders T01',	'Joseph se rend au Japon pour retrouver son petit fils, Jotaro, qu''il n''a pas vu depuis des années. Ce dernier a développé d''étranges pouvoirs qu''il utilise pour se faire un nom chez les voyous. Joseph lui explique qu''il s''agit d''un Stand, une sorte de matérialisation de son esprit combatif, possédant des capacités propres à chacun. Après ces retrouvailles mouvementées, Joseph révèle à son petit fils que Dio, le terrible vampire qui s''était opposé à leur ancêtre, est toujours de ce monde et veut en découdre avec la lignée...',	'68114b629e130.jpg',	2013,	'2759509419'),
(3,	'Le Seigneur Des Anneaux - : Le Seigneur des Anneaux - Tome 1 La Fraternité de l''Anneau',	'En Terre du Milieu, Bilbon Sacquet le hobbit lègue à son neveu Frodon un anneau, sous l’influence de Gandalf le magicien. 

Cet anneau est un instrument de pouvoir absolu forgé par Sauron, seigneur des ténèbres, dans les flammes du Mordor. Il cherche à le récupérer afin de régner sur la Terre du Milieu. Accompagné par la communauté de l’Anneau (composée d’hobbits, d’hommes, de nains et d’elfes), Frodon se lance dans une aventure périlleuse avec les cavaliers noirs à ses trousses.',	'68115049adfca.jpg',	1954,	'2266346768'),
(4,	'Le crime de l''Orient-Express',	'Par le plus grand des hasards, Hercule Poirot se trouve dans la voiture de l’Orient-Express – ce train de luxe qui traverse l’Europe – où un crime féroce a été commis.
Une des plus difficiles et des plus délicates enquêtes commence pour le fameux détective belge.
Autour de ce cadavre, trop de suspects, trop d’alibis.
Un train de luxe bloqué par la neige, un cadavre fardé de plusieurs coups de poignards. A Hercule Poirot de démasquer le coupable parmi les douze passagers du wagon.',	'68116f62416b6.jpg',	1934,	'2253010219'),
(6,	'Orgueil et préjugés',	'Issue d''une famille de la petite gentry anglaise, Elizabeth Bennet ne manque ni d''humour ni de malice. Lors d''un bal, elle rencontre le hautain Mr Darcy, un des hommes les plus riches d''Angleterre mais aussi l''un des plus orgueilleux, qu''elle méprise aussitôt. Après avoir mal jugé le charme de la jeune femme, il tombe amoureux d''elle et mènera une longue lutte intérieure entre ce que lui dictent son coeur et son rang. Comment réussiront-ils à vaincre leurs préjugés et à faire taire leur orgueil pour connaître l''amour ?',	'68117274543c2.jpg',	1813,	'2811239286');

DROP TABLE IF EXISTS "category";
DROP SEQUENCE IF EXISTS category_id_seq;
CREATE SEQUENCE category_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."category" (
    "id" integer DEFAULT nextval('category_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "image" character varying(255),
    CONSTRAINT "category_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "category" ("id", "name", "image") VALUES
(1,	'test',	'6810017d901a1.png'),
(2,	'Essai',	NULL),
(3,	'Shōnen',	NULL),
(4,	'Fantasy',	NULL);

DROP TABLE IF EXISTS "category_book";
CREATE TABLE "public"."category_book" (
    "category_id" integer NOT NULL,
    "book_id" integer NOT NULL,
    CONSTRAINT "category_book_pkey" PRIMARY KEY ("category_id", "book_id")
) WITH (oids = false);

CREATE INDEX idx_407ed97612469de2 ON public.category_book USING btree (category_id);

CREATE INDEX idx_407ed97616a2b381 ON public.category_book USING btree (book_id);

INSERT INTO "category_book" ("category_id", "book_id") VALUES
(1,	5),
(2,	5),
(3,	2),
(4,	3);

DROP TABLE IF EXISTS "doctrine_migration_versions";
CREATE TABLE "public"."doctrine_migration_versions" (
    "version" character varying(191) NOT NULL,
    "executed_at" timestamp(0),
    "execution_time" integer,
    CONSTRAINT "doctrine_migration_versions_pkey" PRIMARY KEY ("version")
) WITH (oids = false);

INSERT INTO "doctrine_migration_versions" ("version", "executed_at", "execution_time") VALUES
('DoctrineMigrations\Version20250407215211',	'2025-04-07 21:52:34',	181),
('DoctrineMigrations\Version20250407215623',	'2025-04-07 21:58:47',	10),
('DoctrineMigrations\Version20250407221840',	'2025-04-07 22:18:47',	5),
('DoctrineMigrations\Version20250407224903',	'2025-04-20 10:07:32',	5),
('DoctrineMigrations\Version20250420100723',	'2025-04-20 10:07:32',	0),
('DoctrineMigrations\Version20250420101457',	'2025-04-20 10:15:04',	5),
('DoctrineMigrations\Version20250420104920',	'2025-04-20 10:49:26',	4),
('DoctrineMigrations\Version20250420105133',	'2025-04-20 10:51:39',	4),
('DoctrineMigrations\Version20250420111345',	'2025-04-20 11:13:51',	7),
('DoctrineMigrations\Version20250420133446',	'2025-04-20 13:34:54',	4),
('DoctrineMigrations\Version20250421120158',	'2025-04-26 09:23:01',	264),
('DoctrineMigrations\Version20250421125559',	'2025-04-26 09:23:02',	268),
('DoctrineMigrations\Version20250421130424',	'2025-04-26 09:23:02',	3),
('DoctrineMigrations\Version20250421135129',	'2025-04-26 09:23:02',	11),
('DoctrineMigrations\Version20250426223940',	'2025-04-26 22:39:52',	7),
('DoctrineMigrations\Version20250427104620',	'2025-04-29 20:15:54',	93),
('DoctrineMigrations\Version20250427141003',	'2025-04-29 20:15:55',	99),
('DoctrineMigrations\Version20250428193043',	'2025-04-29 20:15:55',	22),
('DoctrineMigrations\Version20250429233348',	'2025-04-29 23:34:17',	203),
('DoctrineMigrations\Version20250429235329',	'2025-04-29 23:53:42',	5);

DROP TABLE IF EXISTS "language";
DROP SEQUENCE IF EXISTS language_id_seq;
CREATE SEQUENCE language_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."language" (
    "id" integer DEFAULT nextval('language_id_seq') NOT NULL,
    "language" character varying(50) NOT NULL,
    CONSTRAINT "language_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "language" ("id", "language") VALUES
(1,	'Français'),
(2,	'English'),
(3,	'Español');

DROP TABLE IF EXISTS "language_book";
CREATE TABLE "public"."language_book" (
    "language_id" integer NOT NULL,
    "book_id" integer NOT NULL,
    CONSTRAINT "language_book_pkey" PRIMARY KEY ("language_id", "book_id")
) WITH (oids = false);

CREATE INDEX idx_f9ec497d16a2b381 ON public.language_book USING btree (book_id);

CREATE INDEX idx_f9ec497d82f1baf4 ON public.language_book USING btree (language_id);

INSERT INTO "language_book" ("language_id", "book_id") VALUES
(1,	5),
(2,	5),
(2,	7),
(3,	7);

DROP TABLE IF EXISTS "messenger_messages";
DROP SEQUENCE IF EXISTS messenger_messages_id_seq;
CREATE SEQUENCE messenger_messages_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."messenger_messages" (
    "id" bigint DEFAULT nextval('messenger_messages_id_seq') NOT NULL,
    "body" text NOT NULL,
    "headers" text NOT NULL,
    "queue_name" character varying(190) NOT NULL,
    "created_at" timestamp(0) NOT NULL,
    "available_at" timestamp(0) NOT NULL,
    "delivered_at" timestamp(0),
    CONSTRAINT "messenger_messages_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON COLUMN "public"."messenger_messages"."created_at" IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN "public"."messenger_messages"."available_at" IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN "public"."messenger_messages"."delivered_at" IS '(DC2Type:datetime_immutable)';

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


DELIMITER ;;

CREATE TRIGGER "notify_trigger" AFTER INSERT OR UPDATE ON "public"."messenger_messages" FOR EACH ROW EXECUTE FUNCTION notify_messenger_messages();;

DELIMITER ;

DROP TABLE IF EXISTS "reservation";
DROP SEQUENCE IF EXISTS reservation_id_seq;
CREATE SEQUENCE reservation_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."reservation" (
    "id" integer DEFAULT nextval('reservation_id_seq') NOT NULL,
    "reservation_user_id" integer NOT NULL,
    "book_id" integer NOT NULL,
    "borrowing_date" timestamp(0) NOT NULL,
    CONSTRAINT "reservation_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX idx_42c84955c0fb6810 ON public.reservation USING btree (reservation_user_id);

CREATE INDEX idx_42c8495516a2b381 ON public.reservation USING btree (book_id);

INSERT INTO "reservation" ("id", "reservation_user_id", "book_id", "borrowing_date") VALUES
(7,	15,	6,	'2025-04-30 01:08:19');

DROP TABLE IF EXISTS "tag";
DROP SEQUENCE IF EXISTS tag_id_seq;
CREATE SEQUENCE tag_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."tag" (
    "id" integer DEFAULT nextval('tag_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "image" character varying(255),
    CONSTRAINT "tag_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "tag" ("id", "name", "image") VALUES
(1,	'tag',	NULL);

DROP TABLE IF EXISTS "tag_book";
CREATE TABLE "public"."tag_book" (
    "tag_id" integer NOT NULL,
    "book_id" integer NOT NULL,
    CONSTRAINT "tag_book_pkey" PRIMARY KEY ("tag_id", "book_id")
) WITH (oids = false);

CREATE INDEX idx_25ea1c8716a2b381 ON public.tag_book USING btree (book_id);

CREATE INDEX idx_25ea1c87bad26311 ON public.tag_book USING btree (tag_id);

INSERT INTO "tag_book" ("tag_id", "book_id") VALUES
(1,	7),
(1,	5);

DROP TABLE IF EXISTS "user";
DROP SEQUENCE IF EXISTS user_id_seq;
CREATE SEQUENCE user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."user" (
    "id" integer DEFAULT nextval('user_id_seq') NOT NULL,
    "email" character varying(180) NOT NULL,
    "roles" json NOT NULL,
    "password" character varying(255) NOT NULL,
    "is_verified" boolean NOT NULL,
    CONSTRAINT "user_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE UNIQUE INDEX uniq_identifier_email ON public."user" USING btree (email);

INSERT INTO "user" ("id", "email", "roles", "password", "is_verified") VALUES
(15,	'admin@example.com',	'["ROLE_ADMIN"]',	'$2y$13$3eNWGbrD3/qQJKhC39EX5uv58DqRkBO/yyQIR/YtyJuZyW6V.dUH2',	'1'),
(16,	'user1@example.com',	'["ROLE_USER"]',	'$2y$13$MzV.diq7u/4QtOHoBxoM4.9IKbtkkiAcbfVdm3WTfdgSEjbFo7bjO',	'0'),
(17,	'user2@example.com',	'["ROLE_USER"]',	'$2y$13$iAOqdO6SuT8yfPIf6UYjdON8zcxaqPsADQT5Db1IngE6plraolaaG',	'0'),
(18,	'user3@example.com',	'["ROLE_USER"]',	'$2y$13$AUBSXdiyv620ITAGvihZeul.07pV03kY4297hW.CBnMBttrwfQUkS',	'0'),
(19,	'user4@example.com',	'["ROLE_USER"]',	'$2y$13$h1K5u9wXdXhz0WXr5.xH0uowYmfoHrpsjG.d5.hCnoz3W9Z/g/HCi',	'0');

ALTER TABLE ONLY "public"."author_book" ADD CONSTRAINT "fk_2f0a2bee16a2b381" FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."author_book" ADD CONSTRAINT "fk_2f0a2beef675f31b" FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."category_book" ADD CONSTRAINT "fk_407ed97612469de2" FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."category_book" ADD CONSTRAINT "fk_407ed97616a2b381" FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."language_book" ADD CONSTRAINT "fk_f9ec497d16a2b381" FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."language_book" ADD CONSTRAINT "fk_f9ec497d82f1baf4" FOREIGN KEY (language_id) REFERENCES language(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."reservation" ADD CONSTRAINT "fk_42c8495516a2b381" FOREIGN KEY (book_id) REFERENCES book(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."reservation" ADD CONSTRAINT "fk_42c84955c0fb6810" FOREIGN KEY (reservation_user_id) REFERENCES "user"(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tag_book" ADD CONSTRAINT "fk_25ea1c8716a2b381" FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."tag_book" ADD CONSTRAINT "fk_25ea1c87bad26311" FOREIGN KEY (tag_id) REFERENCES tag(id) ON DELETE CASCADE NOT DEFERRABLE;

-- 2025-04-30 01:09:39 UTC
