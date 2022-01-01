#!/usr/bin/python
# -*- coding: utf-8 -*-

from datetime import datetime
from time import sleep
from intellivue import intellivue as device
import websocket;
import json
import sys

#timescale of plot in min
duration=30

#insert correct monitor IP here
dev_1 = device(sys.argv[1])
dev_1.start_client()
print(sys.argv[1])
last_NBP_time=datetime.strptime("01.01.1990 00:00:00",'%d.%m.%Y %H:%M:%S')
socketClient = websocket.create_connection('ws://127.0.0.1:' + sys.argv[2])

refreshRate = 0.5

try:
    while True:
        props = {
            'refreshRate': refreshRate * 1000
        };
        for key, value in dev_1.get_vital_signs():
            if isinstance(value, datetime):
                props[key] = datetime.timestamp(value)
            else:
                props[key] = value
        if dev_1.is_active == False:
            dev_1.resetValues()
            props = {
                'refreshRate': refreshRate * 1000
            };

        data = {
            'command': 'icumonitor.values.store',
            'parameters': props
        }
        socketClient.send(
            json.dumps(data)
        )
        if dev_1.is_active == False:
            sleep(10);
            dev_1.start_client()
            continue
        
        sleep(refreshRate)

except BaseException as e:
    print (e);
    dev_1.halt_client()
    print("\client halted...\n")
