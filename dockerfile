FROM mattrayner/lamp:1604-php5-base

COPY . /app/

CMD ["/run.sh"]
