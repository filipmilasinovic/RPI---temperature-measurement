#!/usr/bin/env python
import mysql.connector
import os
import glob
import time

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

base_dir='/sys/bus/w1/devices/'
#prvi senzor - promeni device prema trenutno priključenom senzoru
device1_folder = glob.glob(base_dir + '28-000008a7d632')[0]
#drugi a u stvari prvi senzor - promeni device prema trenutno priključenom senzoru
device2_folder = glob.glob(base_dir + '28-000008a7d632')[0]

device1_file = device1_folder + '/w1_slave'
device2_file = device2_folder + '/w1_slave'

def read_temp_raw(dev):
	f = open(dev, 'r')
	lines = f.readlines()
	f.close()
	return lines

def read_temp(dev):
	lines = read_temp_raw(dev)
        while lines[0].strip()[-3:] != 'YES':
		time.sleep(0.2)
		lines = read_temp_raw()
	equals_pos = lines[1].find('t=')
	if equals_pos != -1:
		temp_string = lines[1][equals_pos+2:]
		temp_c = float(temp_string)/1000.0
		return temp_c

mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  passwd="Pa$$w0rd",
  database="temperatura"
)

mycursor = mydb.cursor()

temp1 = read_temp(device1_file)
temp2 = read_temp(device2_file)

sql = "INSERT INTO temperatura (senzor, temperatura) VALUES ('Senzor1', '" + str(temp1) + "')"
mycursor.execute(sql)


sql = "INSERT INTO temperatura (senzor, temperatura) VALUES ('Senzor2', '" + str(temp2) + "')"
mycursor.execute(sql)
mydb.commit()

