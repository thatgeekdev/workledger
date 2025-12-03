#!/usr/bin/env bash
set -euo pipefail


# script que pode ser rodado na runner com acesso ao cluster/prod
# Exemplo: build + push docker image then deploy
IMAGE_REPO=${IMAGE_REPO:-example.com/workledger}
TAG=${GITHUB_SHA:-latest}


# build api image
cd apps/api
docker build -t ${IMAGE_REPO}/api:${TAG} .


# push
docker push ${IMAGE_REPO}/api:${TAG}


# deploy: (exemplo kubectl)
# kubectl set image deployment/api api=${IMAGE_REPO}/api:${TAG} -n namespace