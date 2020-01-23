--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1
-- Dumped by pg_dump version 12.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: check_if_lended(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.check_if_lended() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
    IF NEW.id_ksiazka not in (SELECT id_ksiazka FROM zamowienie WHERE czy_zwrocona IS FALSE) THEN
    return NEW;
    ELSE
    raise notice 'Ksiazka juz wypozyczona!';
    return NULL;
    END IF;
end;
$$;


ALTER FUNCTION public.check_if_lended() OWNER TO postgres;

--
-- Name: check_if_reader_has_book(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.check_if_reader_has_book() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
IF OLD.id_czytelnik not in (SELECT id_czytelnik FROM zamowienie WHERE czy_zwrocona IS FALSE) THEN     
return OLD;
   ELSE           
   raise notice 'Uzytkownik ma wypozyczona ksiazke!';
   return NULL;
    END IF;
end;
$$;


ALTER FUNCTION public.check_if_reader_has_book() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: ksiazka; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ksiazka (
    id_ksiazka integer NOT NULL,
    id_kategoria integer,
    isbn character(13) NOT NULL,
    tytul character varying(64) NOT NULL,
    autor character varying(64) NOT NULL,
    wydawnictwo character varying(64) DEFAULT 'nieznane'::character varying,
    rok character(4) NOT NULL
);


ALTER TABLE public.ksiazka OWNER TO postgres;

--
-- Name: zamowienie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.zamowienie (
    id_zamowienie integer NOT NULL,
    id_czytelnik integer,
    id_ksiazka integer,
    data_odbioru date,
    data_zwrotu date,
    czy_zwrocona boolean DEFAULT false,
    CONSTRAINT zamowienie_check CHECK ((data_zwrotu >= data_odbioru)),
    CONSTRAINT zamowienie_data_odbioru_check CHECK ((data_odbioru > '2019-01-01'::date))
);


ALTER TABLE public.zamowienie OWNER TO postgres;

--
-- Name: availablebooks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.availablebooks AS
 SELECT id_ksiazka,
    ksiazka.id_kategoria,
    ksiazka.tytul,
    ksiazka.autor,
    ksiazka.wydawnictwo,
    ksiazka.rok,
    ksiazka.isbn
   FROM (public.ksiazka
     FULL JOIN public.zamowienie USING (id_ksiazka))
  GROUP BY id_ksiazka, ksiazka.id_kategoria, ksiazka.tytul, ksiazka.autor, ksiazka.wydawnictwo, ksiazka.rok, ksiazka.isbn
 HAVING (COALESCE(max(( SELECT z.data_zwrotu
           FROM public.zamowienie z
          WHERE (z.id_ksiazka = ksiazka.id_ksiazka))), '1970-01-01'::date) <= CURRENT_DATE);


ALTER TABLE public.availablebooks OWNER TO postgres;

--
-- Name: czytelnik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.czytelnik (
    id_czytelnik integer NOT NULL,
    imie character varying(64) NOT NULL,
    nazwisko character varying(64) NOT NULL,
    telefon character varying(16) DEFAULT 'brak'::character varying,
    email character varying(64) NOT NULL
);


ALTER TABLE public.czytelnik OWNER TO postgres;

--
-- Name: czytelnik_id_czytelnik_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.czytelnik_id_czytelnik_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.czytelnik_id_czytelnik_seq OWNER TO postgres;

--
-- Name: czytelnik_id_czytelnik_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.czytelnik_id_czytelnik_seq OWNED BY public.czytelnik.id_czytelnik;


--
-- Name: kategorie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kategorie (
    id_kategoria integer NOT NULL,
    nazwa character varying(32) NOT NULL
);


ALTER TABLE public.kategorie OWNER TO postgres;

--
-- Name: kategorie_id_kategoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kategorie_id_kategoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kategorie_id_kategoria_seq OWNER TO postgres;

--
-- Name: kategorie_id_kategoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kategorie_id_kategoria_seq OWNED BY public.kategorie.id_kategoria;


--
-- Name: ksiazka_id_ksiazka_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ksiazka_id_ksiazka_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ksiazka_id_ksiazka_seq OWNER TO postgres;

--
-- Name: ksiazka_id_ksiazka_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ksiazka_id_ksiazka_seq OWNED BY public.ksiazka.id_ksiazka;


--
-- Name: zamowienie_id_zamowienie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.zamowienie_id_zamowienie_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.zamowienie_id_zamowienie_seq OWNER TO postgres;

--
-- Name: zamowienie_id_zamowienie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.zamowienie_id_zamowienie_seq OWNED BY public.zamowienie.id_zamowienie;


--
-- Name: czytelnik id_czytelnik; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.czytelnik ALTER COLUMN id_czytelnik SET DEFAULT nextval('public.czytelnik_id_czytelnik_seq'::regclass);


--
-- Name: kategorie id_kategoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategorie ALTER COLUMN id_kategoria SET DEFAULT nextval('public.kategorie_id_kategoria_seq'::regclass);


--
-- Name: ksiazka id_ksiazka; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ksiazka ALTER COLUMN id_ksiazka SET DEFAULT nextval('public.ksiazka_id_ksiazka_seq'::regclass);


--
-- Name: zamowienie id_zamowienie; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zamowienie ALTER COLUMN id_zamowienie SET DEFAULT nextval('public.zamowienie_id_zamowienie_seq'::regclass);


--
-- Data for Name: czytelnik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.czytelnik (id_czytelnik, imie, nazwisko, telefon, email) FROM stdin;
1	Barbara	Kiszewska	677751870	barbara1@onet.pl
2	Jadwiga	Bilecka	812785461	jasiabil@gmail.com
3	Ewa	Masztaler	689190910	ewamasz@agh.edu.pl
4	Barbara	Manczynska	164930028	maczynska@interia.pl
5	Ewa	Niemota	462740297	efkaa123@onet.pl
6	Jadwiga	Fulecka	942851943	jadful@gmail.com
7	Boleslaw	Brynski	145639641	b69@onet.pl
8	Katarzyna	Dawro	561835964	dawrokk@interia.pl
9	Jolanta	Filecka	413374221	jolfil@agh.edu.pl
10	Michal	Fadecki	142706771	michcio@onet.pl
11	Michal	Kureka	265458045	michkur@gmail.com
12	Robert	Dido	159392045	dildorobert@gmail.com
13	Rafal	Dobek	267448116	misiaczek146@gmail.com
14	Tadeusz	Komasa	895344383	komasa@onet.pl
15	Michal	Komor	805734948	mickom@agh.edu.pl
16	Robert	Surwagon	701556377	skurwagon@interia.pl
17	Tadeusz	Kowalski	889319385	tkowal@onet.pl
18	Wiktor	Krupicki	833306801	wikotr999@agh.edu.pl
19	Wiktor	Labuda	598744371	wikilab@onet.pl
20	Andrzej	Twarnowski	729513752	atwar@interia.pl
\.


--
-- Data for Name: kategorie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kategorie (id_kategoria, nazwa) FROM stdin;
1	biografia
2	fantasatyka
3	historia
4	informatyka
5	kryminal
\.


--
-- Data for Name: ksiazka; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ksiazka (id_ksiazka, id_kategoria, isbn, tytul, autor, wydawnictwo, rok) FROM stdin;
1	1	6433240700401	Szczerze	Donald Tusk	Agora	2019
2	1	6433240700401	Szczerze	Donald Tusk	Agora	2019
3	1	6433240700401	Szczerze	Donald Tusk	Agora	2019
4	1	6433240700401	Szczerze	Donald Tusk	Agora	2019
5	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
6	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
7	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
8	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
9	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
10	1	4194498929923	Dwoch papiezy	McCarten Anthony	Wydawnictwo Marginesy	2019
11	1	3592512630839	Brzydki zly i szczery	Ostrowski Adam	Wielka Litera	2019
12	1	3592512630839	Brzydki zly i szczery	Ostrowski Adam	Wielka Litera	2019
13	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
14	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
15	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
16	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
17	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
18	2	5911466621463	Hobbit	Tolkien John Ronald Reuel	Wydawnictwo Iskry	2014
19	2	3023406612661	Wywiad z wampirem	Rice Anne	Dom Wydawniczy Rebis	2018
20	2	3023406612661	Wywiad z wampirem	Rice Anne	Dom Wydawniczy Rebis	2018
21	2	3023406612661	Wywiad z wampirem	Rice Anne	Dom Wydawniczy Rebis	2018
22	2	3023406612661	Wywiad z wampirem	Rice Anne	Dom Wydawniczy Rebis	2018
23	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
24	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
25	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
26	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
27	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
28	2	8875170219338	Metro 2033	Glukhovsky Dmitry	Wydawnictwo Insignis	2015
29	3	0399680722083	Historia Bez Cenzury	Drewniak Wojciech	Historia bez cenzury	2016
30	3	5095029659742	Nie tylko husaria	Sikora Radowlaw	Spoleczny Instytut Wydawniczy Znak	2020
31	4	0704187856334	Czysty kod. Podrecznik dobrego programisty	Robert C.Martin	Wydawnictwo Helion	2014
32	4	8384147631800	Niewidzialny w sieci. Sztuka zacierania sladow	Mitnick Kevin	Wydawnictwo Pascal	2017
33	5	1166865191813	Glosy z zaswiatow	Mroz Remigiusz	Wydawnictwo Filia	2020
34	5	9407324313700	W umysle mordercy	Wronski Lukasz	Skarpa Warszawska	2019
\.


--
-- Data for Name: zamowienie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.zamowienie (id_zamowienie, id_czytelnik, id_ksiazka, data_odbioru, data_zwrotu, czy_zwrocona) FROM stdin;
17	2	11	2020-01-23	2020-02-23	f
\.


--
-- Name: czytelnik_id_czytelnik_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.czytelnik_id_czytelnik_seq', 22, true);


--
-- Name: kategorie_id_kategoria_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kategorie_id_kategoria_seq', 5, true);


--
-- Name: ksiazka_id_ksiazka_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ksiazka_id_ksiazka_seq', 34, true);


--
-- Name: zamowienie_id_zamowienie_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.zamowienie_id_zamowienie_seq', 17, true);


--
-- Name: czytelnik czytelnik_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.czytelnik
    ADD CONSTRAINT czytelnik_pkey PRIMARY KEY (id_czytelnik);


--
-- Name: kategorie kategorie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kategorie
    ADD CONSTRAINT kategorie_pkey PRIMARY KEY (id_kategoria);


--
-- Name: ksiazka ksiazka_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ksiazka
    ADD CONSTRAINT ksiazka_pkey PRIMARY KEY (id_ksiazka);


--
-- Name: zamowienie zamowienie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zamowienie
    ADD CONSTRAINT zamowienie_pkey PRIMARY KEY (id_zamowienie);


--
-- Name: zamowienie check_if_lended_t; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_if_lended_t BEFORE INSERT ON public.zamowienie FOR EACH ROW EXECUTE FUNCTION public.check_if_lended();


--
-- Name: czytelnik check_if_reader_has_book_t; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_if_reader_has_book_t BEFORE DELETE ON public.czytelnik FOR EACH ROW EXECUTE FUNCTION public.check_if_reader_has_book();


--
-- Name: ksiazka ksiazka_id_kategoria_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ksiazka
    ADD CONSTRAINT ksiazka_id_kategoria_fkey FOREIGN KEY (id_kategoria) REFERENCES public.kategorie(id_kategoria) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: zamowienie zamowienie_id_czytelnik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zamowienie
    ADD CONSTRAINT zamowienie_id_czytelnik_fkey FOREIGN KEY (id_czytelnik) REFERENCES public.czytelnik(id_czytelnik) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zamowienie zamowienie_id_ksiazka_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zamowienie
    ADD CONSTRAINT zamowienie_id_ksiazka_fkey FOREIGN KEY (id_ksiazka) REFERENCES public.ksiazka(id_ksiazka) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: TABLE ksiazka; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.ksiazka TO projekt;


--
-- Name: TABLE zamowienie; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.zamowienie TO projekt;


--
-- Name: TABLE availablebooks; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.availablebooks TO projekt;


--
-- Name: TABLE czytelnik; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.czytelnik TO projekt;


--
-- Name: SEQUENCE czytelnik_id_czytelnik_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.czytelnik_id_czytelnik_seq TO projekt;


--
-- Name: TABLE kategorie; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.kategorie TO projekt;


--
-- Name: SEQUENCE kategorie_id_kategoria_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.kategorie_id_kategoria_seq TO projekt;


--
-- Name: SEQUENCE ksiazka_id_ksiazka_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.ksiazka_id_ksiazka_seq TO projekt;


--
-- Name: SEQUENCE zamowienie_id_zamowienie_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.zamowienie_id_zamowienie_seq TO projekt;


--
-- PostgreSQL database dump complete
--

