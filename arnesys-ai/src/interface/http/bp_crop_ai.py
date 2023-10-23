from flask import (
    Blueprint, request, jsonify, make_response
)
from .crop_controller import pest_detect,recommend_crop

bp = Blueprint('crop_ai',__name__,url_prefix='/crop')

bp.route('/predict/recommend',methods=['POST'])(recommend_crop)
bp.route('/predict/pest',methods=['POST'])(pest_detect)
