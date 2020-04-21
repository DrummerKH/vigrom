FROM nginx:1.13

COPY ./nginx.conf /etc/nginx/

COPY ./sites/vigrom.conf /etc/nginx/conf.d/

RUN rm -f /etc/nginx/conf.d/default.conf
RUN rm -f /etc/nginx/conf.d/examplessl.conf

CMD ["nginx"]
