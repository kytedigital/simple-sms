#!/bin/bash

kubectl create secret tls shopify-sms.apps --key=.secrets/shopify-sms_apps_kyte_digital.key --cert=.secrets/shopify-sms_apps_kyte_digital.crt