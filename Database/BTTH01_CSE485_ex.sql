--a
SELECT tieude FROM baiviet INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai WHERE theloai.ten_tloai = N'Nhạc trữ tình';
--b
SELECT tieude FROM baiviet INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia WHERE tacgia.ten_tgia = N'Nhacvietplus';
--c
SELECT ten_tloai FROM theloai LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai WHERE baiviet.ma_bviet IS null;
--d
SELECT
	baiviet.ma_bviet AS 'Mã bài viết',
    baiviet.tieude AS 'Tên bài viết',
    baiviet.ten_bhat AS 'Tên bài hát',
    tacgia.ten_tgia AS 'Tên tác giả',
    theloai.ten_tloai AS 'Tên thể loại',
    baiviet.ngayviet AS 'Ngày viết'
FROM baiviet INNER JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia INNER JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;
--e 
SELECT 
    theloai.ten_tloai AS 'Thể loại',
    COUNT(baiviet.ma_bviet) AS 'Số bài viết'
FROM 
    theloai
LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
GROUP BY 
    theloai.ten_tloai
ORDER BY 
    COUNT(baiviet.ma_bviet) DESC
LIMIT 1;
--f
SELECT 
    tacgia.ten_tgia AS 'Tác giả',
    COUNT(baiviet.ma_bviet) AS 'Số bài viết'
FROM 
    tacgia
LEFT JOIN baiviet ON tacgia.ma_tgia = baiviet.ma_tgia
GROUP BY 
    tacgia.ten_tgia
ORDER BY 
    COUNT(baiviet.ma_bviet) DESC
LIMIT 2;
--g
SELECT 
    ma_bviet AS 'Mã bài viết',
    tieude AS 'Tên bài viết',
    ten_bhat AS 'Tên bài hát'
FROM 
    baiviet
WHERE 
    ten_bhat LIKE '%yêu%' OR
    ten_bhat LIKE '%thương%' OR
    ten_bhat LIKE '%anh%' OR
    ten_bhat LIKE '%em%';

--h
SELECT 
    ma_bviet AS 'Mã bài viết',
    tieude AS 'Tên bài viết',
    ten_bhat AS 'Tên bài hát'
FROM 
    baiviet
WHERE 
    tieude LIKE '%yêu%' OR
    tieude LIKE '%thương%' OR
    tieude LIKE '%anh%' OR
    tieude LIKE '%em%' OR
    ten_bhat LIKE '%yêu%' OR
    ten_bhat LIKE '%thương%' OR
    ten_bhat LIKE '%anh%' OR
    ten_bhat LIKE '%em%';