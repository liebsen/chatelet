mysql -uroot -pChat3leta$. chatelet -B -e "SELECT * FROM products;" | sed "s/'/\'/;s/\t/\",\"/g;s/^/\"/;s/$/\"/;s/\n//g" > ./dump_products.csv

