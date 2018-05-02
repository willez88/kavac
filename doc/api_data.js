define({ "api": [
  {
    "type": "get",
    "url": "/cities",
    "title": "Información de Ciudades",
    "permission": [
      {
        "name": "auth"
      }
    ],
    "name": "Index",
    "group": "City",
    "version": "1.0.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "records",
            "description": "<p>Listado de ciudades</p>"
          }
        ],
        "records": [
          {
            "group": "records",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>Identificador de la Ciudad</p>"
          },
          {
            "group": "records",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Nombre de la Ciudad</p>"
          },
          {
            "group": "records",
            "type": "integer",
            "optional": false,
            "field": "estate_id",
            "description": "<p>Identificador del Estado al que pertenece la Ciudad</p>"
          },
          {
            "group": "records",
            "type": "datetime",
            "optional": false,
            "field": "created_at",
            "description": "<p>Fecha en la que se creo el registro</p>"
          },
          {
            "group": "records",
            "type": "datetime",
            "optional": false,
            "field": "updated_at",
            "description": "<p>Fecha de la última modificación</p>"
          },
          {
            "group": "records",
            "type": "datetime",
            "optional": false,
            "field": "deleted_at",
            "description": "<p>Fecha en la que se eliminó el registro</p>"
          },
          {
            "group": "records",
            "type": "array",
            "optional": false,
            "field": "estate",
            "description": "<p>Datos del Estado asociado a la Ciudad</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/CityController.php",
    "groupTitle": "City"
  }
] });