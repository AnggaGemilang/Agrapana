from flask import (
    request, make_response
)
from src.service.CropRecommendModel import CropRecommendation
from src.service.PestDetect import PestDetect

def recommend_crop():
  data = request.get_json()
  x = data['sensor_data']
  model = CropRecommendation()
  try:
    result = model.predict(x)
    response = make_response({
      'recommend_crop':result
    }, 200)
    return response
  except Exception as e:
    print(e)
    response = make_response({
      'error':'gagal'
    }, 200)
    return response
  
  
def pest_detect():
  data = request.get_json()
  x = data['sensor_data']
  model = PestDetect()
  try:
    result = model.predict(x)
    response = make_response({
      'Thripidae': result
    }, 200)
    return response
  except Exception as e:
    print(e)
    response = make_response({
      'error':'gagal'
    }, 200)
    return response
