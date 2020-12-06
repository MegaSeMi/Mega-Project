FROM nginx:1.15.3

RUN rm /etc/nginx/conf.d/default.conf

ADD etc/nginx/html/index.html etc/nginx/html/index.html
ADD etc/nginx/nginx.conf /etc/nginx/nginx.conf
ADD etc/nginx/conf.d/api.conf /etc/nginx/conf.d/api.conf
