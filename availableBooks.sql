CREATE
OR REPLACE VIEW public.availableBooks AS
SELECT
    id_ksiazka,
    id_kategoria,
    tytul,
    autor,
    wydawnictwo,
    rok,
    isbn
FROM
    ksiazka FULL
    JOIN zamowienie USING(id_ksiazka)
WHERE
    COALESCE(
        (
            SELECT
                czy_zwrocona
            FROM
                zamowienie z
            WHERE
                z.id_ksiazka = ksiazka.id_ksiazka
            ORDER BY
                data_zwrotu DESC
            LIMIT
                1
        ), true
    ) = true
GROUP BY
    id_ksiazka,
    id_kategoria,
    tytul,
    autor,
    wydawnictwo,
    rok,
    isbn;