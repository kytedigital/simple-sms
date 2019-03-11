#!/bin/bash

# Usage: ./build.sh gcr.io/shopify-sms 0.7

# Before you begin, you need to create a new project in GCP and note down the project ID.
# Set the repository to prefix (just replace the shopify-sms bit)
# Run gcloud auth configure-docker to configure the Docker client

VERSION=$2
REPOSITORY_PREFIX=$1

docker build . -t shopify-sms:$VERSION
docker build . -t shopify-sms-worker:$VERSION -f Dockerfile.worker

docker tag shopify-sms:$VERSION $REPOSITORY_PREFIX/shopify-sms:$VERSION
docker tag shopify-sms-worker:$VERSION $REPOSITORY_PREFIX/shopify-sms-worker:$VERSION

docker push $REPOSITORY_PREFIX/shopify-sms:$VERSION
docker push $REPOSITORY_PREFIX/shopify-sms-worker:$VERSION