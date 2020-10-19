-- EXERCICE 1

DROP DATABASE IF EXISTS EvalEx1;
CREATE DATABASE EvalEx1;
USE EvalEx1;

CREATE TABLE `Client`(
    cli_num INT NOT NULL AUTO_INCREMENT,
    cli_nom VARCHAR(50),
    cli_adresse VARCHAR(50),
    cli_tel VARCHAR(50),
    PRIMARY KEY (cli_num)
);

CREATE TABLE `Produit`(
	pro_num INT NOT NULL PRIMARY KEY,
	pro_libelle VARCHAR(50),
	pro_description VARCHAR(50)	
);

CREATE TABLE `Commande`(
	com_num INT NOT NULL AUTO_INCREMENT,
	cli_num INT NOT NULL,
	com_date DATETIME,
	com_obs VARCHAR(50),
	PRIMARY KEY (com_num),
	CONSTRAINT Commande_Client_FK FOREIGN KEY (cli_num) REFERENCES `Client`(cli_num)
);

CREATE TABLE `est_compose` (
	com_num INT NOT NULL,
	pro_num INT NOT NULL,
	est_qte INT,
	CONSTRAINT Commande_Est_FK FOREIGN KEY (com_num) REFERENCES `Commande`(com_num),
	CONSTRAINT Commande_Produit_FK FOREIGN KEY (pro_num) REFERENCES `Produit`(pro_num),
	PRIMARY KEY (com_num, pro_num)
);

-- on crée un index sur le champ 'cli_nom' de la table 'client'
CREATE INDEX idx_cli_nom
ON `client`(cli_nom);

-- EXERCICE 2: NORTHDWIND

--liste des contacts Francais (customers)
SELECT CompanyName AS 'Société',
ContactName AS 'contact',
ContactTitle AS 'Fonction',
Phone AS 'Téléphone'
FROM Customers
WHERE country='France';

-- liste des produits vendus par Exotic Liquids
SELECT ProductName AS 'Produit',
UnitPrice AS 'Prix'
FROM Products
INNER JOIN Suppliers ON Suppliers.SupplierID=Products.SupplierID
AND Suppliers.CompanyName='Exotic Liquids';

-- Nombre de produits vendus par les fournisseurs Francais dnas l'ordre décroissant
SELECT Suppliers.CompanyName AS 'Fournisseur',
COUNT(Products.ProductID) AS 'Nbre Produits'
FROM Products
INNER JOIN Suppliers ON Suppliers.SupplierID=Products.SupplierID
AND Suppliers.Country='France'
GROUP BY Suppliers.CompanyName
ORDER BY 2 DESC;

--  Liste des clients Français ayant plus de 10 commandes
SELECT Customers.CompanyName AS 'Client',
COUNT(Orders.OrderID) AS 'Nbre commandes'
FROM Customers
INNER JOIN  Orders ON
Customers.CustomerID=Orders.CustomerID AND
Customers.Country='France'
GROUP BY Customers.CompanyName
HAVING (COUNT(Orders.OrderID)>10);

-- Liste des pays ayant un chiffre d'affaires > 30000
SELECT
customers.CompanyName AS 'Client',
(SUM((`order details`.UnitPrice)*(`order details`.Quantity))) AS 'CA',
customers.Country AS 'Pays'
FROM `order details`
INNER JOIN orders ON `order details`.orderID=orders.OrderID
INNER JOIN customers ON orders.customerID=customers.CustomerID
GROUP BY customers.customerID
HAVING (SUM((`order details`.UnitPrice)*(`order details`.Quantity)))>30000
ORDER BY 2 desc;


-- Liste des pays dont les clients ont passé commande de produits fournis par 'Exotic Liquids'
SELECT customers.country AS 'Pays'
FROM customers
INNER JOIN orders ON orders.customerID=customers.customerID
INNER JOIN `order details` ON `order details`.orderID=orders.OrderID
INNER JOIN products ON products.productID=`order details`.productID
INNER JOIN suppliers ON suppliers.supplierID=products.supplierID
AND suppliers.CompanyName='Exotic Liquids'
GROUP BY customers.country
ORDER BY 1 ASC;

-- Montant des ventes de 1997 :
SELECT (SUM((`order details`.UnitPrice)*(`order details`.Quantity))) AS 'Montant ventes 97'
FROM `order details`
INNER JOIN orders WHERE SUBSTR(Orders.orderDate, 1,4)=1997
AND `order details`.orderID=orders.OrderID;



-- Montant des ventes de 1997 mois par mois :
SELECT SUBSTR(Orders.orderDate, 6,2) AS 'Mois 97',
(SUM((`order details`.UnitPrice)*(`order details`.Quantity))) AS 'Montant ventes'
FROM `order details`
INNER JOIN orders WHERE SUBSTR(Orders.orderDate, 1,4)=1997 AND `order details`.orderID=orders.OrderID
GROUP BY SUBSTR(Orders.orderDate, 6,2);

-- Depuis quelle date le client « Du monde entier » n’a plus commandé ?
SELECT MAX(orders.orderdate) AS 'Date de dernière commande'
FROM orders
INNER JOIN customers ON orders.customerID=customers.customerID
and customers.CompanyName='Du monde entier';

-- Quel est le délai moyen de livraison en jours ?
SELECT round(avg(DATEdiff(orders.shippedDate,orders.orderDate)))
AS 'Délai moyen de livraison en jours'
FROM orders;