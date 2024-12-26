#!/bin/bash

ROOT_PATH="$(dirname "$(dirname "$(realpath "$0")")")"
CONFIG_PATH="$ROOT_PATH/ssl/ssl-config.conf"
CERT_PATH="$ROOT_PATH/ssl/certs/mycert.crt"
KEY_PATH="$ROOT_PATH/ssl/private/mycert.key"
SCRIPT_LABEL="build-ssl-certificate.sh"

# Check if the certificate and key files already exist
if [ -f "$CERT_PATH" ] && [ -f "$KEY_PATH" ]; then
    echo "$SCRIPT_LABEL: SSL certificate and key already exist"
    exit 0
fi

# Create directories if they don't exist
mkdir -p "$(dirname "$CERT_PATH")"
mkdir -p "$(dirname "$KEY_PATH")"

# Create a temporary OpenSSL config file
echo "[req]
distinguished_name = req_distinguished_name
x509_extensions = v3_req
prompt = no

[req_distinguished_name]
CN = localhost

[v3_req]
basicConstraints = CA:FALSE
keyUsage = digitalSignature, keyEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = localhost" > "$CONFIG_PATH"

# Generate the SSL certificate
echo "$SCRIPT_LABEL: Generating SSL certificate..."
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout "$KEY_PATH" -out "$CERT_PATH" \
    -config "$CONFIG_PATH"

# Check if the SSL certificate was generated successfully
if [ $? -eq 0 ]; then
    echo "$SCRIPT_LABEL: SSL certificate generated successfully"
    rm "$CONFIG_PATH"
else
    echo "$SCRIPT_LABEL: Failed to generate SSL certificate"
    rm "$CONFIG_PATH"
    exit 1
fi