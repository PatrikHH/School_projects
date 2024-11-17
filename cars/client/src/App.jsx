import "./App.css";
import { useEffect, useState } from "react";
import CarTable from "./components/CarTable/CarTable";
import UniForm from "./components/UniForm/UniForm";
import FilterForm from "./components/FilterForm/FilterForm";
import axios from "axios";


function App() {
  const [cars, setCars] = useState([]);
  const [newCar, setNewCar] = useState({
    brand: "",
    model: "",
    reg: "",
    km: "",
    year: "",
  });
  const [carToChange, setCarToChange] = useState({
    id: 0,
    brand: "",
    model: "",
    reg: "",
    km: "",
    year: "",
  });
  const [carsToShow, setCarsToShow] = useState([]);

// ----- vsechna auta z databaze - getCars
const getCars = () => {
  axios.get("https://patrik-hubka.8u.cz/projects/cars/server/?action=getAll").then((response) => {
    if (Array.isArray(response.data)){
      setCars(response.data)
      setCarsToShow(response.data)
    }
  })
  .catch((error) => {
    console.error("Nastala chyba", error)
    alert(`Nastala chyba: ${error}`)
  })
}

useEffect(() => {
  getCars()
}, []);
// ----- specificka auta z databaze - filterCars

  const filterCars = (ids) => {
    // [1,2,3] ... "1,2,3"
    const param = ids.join();
    axios.get(`https://patrik-hubka.8u.cz/projects/cars/server/?action=getSpec&ids=${param}`).then((response) => {
      if (Array.isArray(response.data)) {
        setCarsToShow(response.data)
      }
    })
      .catch((error) => {
        console.error("Nastala chyba", error)
        alert(`Nastala chyba: ${error}`)
    })
  }

  // ----- mazani auta z db: deleteCar
  // http://localhost/php/cars_backend/5...chceme vymazat auto s id 5
  const deleteCar = (id) => {
    axios.delete(`https://patrik-hubka.8u.cz/projects/cars/server/${id}`).then((response ) => {
      console.log(response.data)
      getCars()
      alert("auto bylo uspesne smazano")
    })
      .catch((error) => {
        console.error("Nastala chyba", error)
        alert(`Nastala chyba: ${error}`)
      })
  }
// ----- pridani auta do db: insertCar
const insertCar = (car) => {
  axios 
    .post("https://patrik-hubka.8u.cz/projects/cars/server/", car)
    .then((response) => {
      console.log(response.data)
      getCars()
      alert("Auto uspesne prodano.")
    })
    .catch((error) => {
      console.error("Nastala chyba", error)
      alert(`Nastala chyba: ${error}`)
    })
}

  // ----- editace auta v db: updateCar
  const updateCar = (car) => {
    axios
      .put("https://patrik-hubka.8u.cz/projects/cars/server/", car)
      .then((response) => {
        console.log(response.data)
        getCars()
        alert("Auto uspesne upraveno.")
      })
      .catch((error) => {
        console.error("Nastala chyba", error)
        alert(`Nastala chyba: ${error}`)
      })
  }





  const handleNewData = (updatedCar, source) => {
    switch (source) {
      case "add-car-form": {
        setNewCar(updatedCar);
        break;
      }
      case "change-car-form": {
        setCarToChange(updatedCar);
        break;
      }
      default:
        break;
    }
  };

  const fillEmptyInfos = (car) => {
    const filledCar = {
      ...car,
      brand: car.brand.trim() ? car.brand : "empty",
      model: car.model.trim() ? car.model : "empty",
      reg: car.reg.trim() ? car.reg : "empty",
      km: parseInt(car.km) || 0,
      year: parseInt(car.year) || 0,
    };
    return filledCar;
  };

  const confirmCar = (car) => {
    return window.confirm(
      "Opravdu chcete odeslat data?\n" +
        `Značka: ${car.brand}\n` +
        `Model: ${car.model}\n` +
        `Reg.značka: ${car.reg}\n` +
        `Kilometry: ${car.km}\n` +
        `Rok výroby: ${car.year}\n`
    );
  };

  const handleUpdate = (source) => {
    let temp;
    switch (source) {
      case "add-car-form": {
        temp = fillEmptyInfos(newCar);
        if (confirmCar(temp)) {
          insertCar(temp);
          setNewCar({
            brand: "",
            model: "",
            reg: "",
            km: "",
            year: "",
          });
          alert("Data byla úspěšně odeslána");
        } else {
          alert("Odeslání dat bylo zrušeno");
        }
        break;
      }
      case "change-car-form": {
        temp = fillEmptyInfos(carToChange);
        if (confirmCar(temp)) {
          const index = cars.findIndex((car) => car.id === temp.id);
          if (index !== -1) {
            updateCar(temp)
            setCarToChange({
              id: 0,
              brand: "",
              model: "",
              reg: "",
              km: "",
              year: "",
            });
            alert("Aktualizace dat úspěšná");
          } else {
            alert("Auto s daným id nebylo nalezeno");
            setCarToChange({
              id: 0,
              brand: "",
              model: "",
              reg: "",
              km: "",
              year: "",
            });
          }
        } else {
          alert("Aktualizace neproběhla");
        }
        break;
      }
      default:
        break;
    }
  };

  const handleDelete = (idToDel) => {
    // const temp = cars.filter((car) => car.id !== idToDel);
    // setCars(temp);
    // setCarsToShow(temp);
    deleteCar(idToDel)
  };

  const handleChange = (idToChange) => {
    const temp = cars.filter((car) => car.id === idToChange);
    setCarToChange(...temp);
  };
  // useEffect(() => {
  //   console.log(carToChange);
  // }, [carToChange]);

  // useEffect(() => {
  //   console.log(cars);
  // }, [cars]);

  const handleFilterData = (filteredCars) => {
    const ids = filteredCars.map((car) => car.id)
    filterCars(ids);
  };

  return (
    <div className="container">
      <FilterForm data={cars} handleFilterData={handleFilterData} />
      <CarTable
        data={carsToShow}
        handleDelete={handleDelete}
        handleChange={handleChange}
      />
      <p>Přidání nového auta</p>
      <UniForm
        id="add-car-form"
        data={newCar}
        handleNewData={handleNewData}
        handleUpdate={handleUpdate}
      />
      <p>Úpravy existujícího auta</p>
      <UniForm
        id="change-car-form"
        data={carToChange}
        handleNewData={handleNewData}
        handleUpdate={handleUpdate}
      />
    </div>
  );
}

export default App;
