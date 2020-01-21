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
GROUP BY
    id_ksiazka,
    id_kategoria,
    tytul,
    autor,
    wydawnictwo,
    rok, 
    isbn
HAVING
    COALESCE(
        MAX(
            (
                SELECT
                    data_zwrotu
                from
                    zamowienie z
                WHERE
                    z.id_ksiazka = ksiazka.id_ksiazka
            )
        ),
        '1970-01-01' :: date
    ) < current_date :: date;