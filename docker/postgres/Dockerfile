FROM postgres

COPY pg_hba.conf /docker-entrypoint-initdb.d

# Copy pg_hba.conf to PGDATA directory
RUN echo "cp /docker-entrypoint-initdb.d/pg_hba.conf /var/lib/postgresql/data/pgdata/" > /docker-entrypoint-initdb.d/pg_hba.sh