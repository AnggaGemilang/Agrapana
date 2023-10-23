from flask import Flask
import pickle
from src.service.CropRecommendModel import CropRecommendation
from src.interface.http import bp_crop_ai

def create_server():
  app = Flask(__name__)
  app.register_blueprint(bp_crop_ai.bp)
  return app