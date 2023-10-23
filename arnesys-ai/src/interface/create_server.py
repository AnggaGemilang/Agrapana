from flask import Flask
import pickle
from src.service.CropRecommendModel import CropRecommendation
from src.interface.http import bp_crop_ai
from flask_cors import CORS, cross_origin 

def create_server():
  app = Flask(__name__)
  CORS(app)
  
  app.register_blueprint(bp_crop_ai.bp)
  return app