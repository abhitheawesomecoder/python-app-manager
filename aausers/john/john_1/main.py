import os
import json
import time
import datetime
import logging

def get_US_time():
    US_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    US_time = datetime.datetime.strptime(US_time,"%Y-%m-%d %H:%M:%S")
    return US_time

def path_setting(US_time):
    root = os.getcwd()
    US_date = US_time.date()
    US_path = os.path.join(root, 'logs', str(US_date))

    try:
        os.makedirs(US_path)
    except Exception:
        pass

    os.chdir(US_path)
    return US_path

def info(msg):
    print('[{}] {}'.format(datetime.datetime.now(),msg))
    logging.info(msg)

if __name__ == '__main__':
    with open('config.json', 'r') as f:
        config = json.load(f)

    US_time = get_US_time()
    US_path = path_setting(US_time)
    logging.basicConfig(filename=os.path.join(US_path, 'client.log'), \
                        level=logging.INFO, \
                        format='%(asctime)s - %(levelname)s - %(message)s')

    while True:
        info(config)
        time.sleep(5)
