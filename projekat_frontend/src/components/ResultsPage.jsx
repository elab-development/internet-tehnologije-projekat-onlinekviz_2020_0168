import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { MdArrowBack } from "react-icons/md";

function ResultsPage({ username, result, resetResult }) {
  const navigate = useNavigate();
  const [previousResults, setPreviousResults] = useState([]);

  if (username === '') username = 'Guest';

  const handleClick = () => {
    resetResult();
    navigate('/rooms');
  };

  const user = localStorage.getItem('user');
  const roomname = localStorage.getItem('naziv_sobe');

  const handleBack = () => {
    navigate('/startgame');
  };

  const handleSaveResult = async () => {
    try {
      console.log('Saving result:', { naziv_sobe: roomname, ime_igraca: user, trenutni_rezultat: result });
      const response = await fetch('http://127.0.0.1:8000/api/rezultati', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          naziv_sobe: roomname,
          ime_igraca: user,
          trenutni_rezultat: result,
        }),
      });

      if (response.ok) {
        console.log('Successful result.');
      } else {
        console.error('Error saving result.');
      }
    } catch (error) {
      console.error('Error sending result:', error);
    }
  };

  const fetchPreviousResults = async () => {
    try {
      console.log('Fetching previous results for room:', roomname);
      const response = await fetch(`http://127.0.0.1:8000/api/rezultati/${roomname}`);
      const data = await response.json();
      console.log('Fetched previous results:', data);
      setPreviousResults(data);
    } catch (error) {
      console.error('Greska u dohvatanju prethodnih rezultata:', error);
    }
  };

  useEffect(() => {
    fetchPreviousResults().then(() => {
      handleSaveResult();
    });
  }, []);

  useEffect(() => {
    const script = document.createElement('script');
    script.src = 'https://www.gstatic.com/charts/loader.js';
    script.async = true;
    script.onload = () => {
      if (window.google) {
        window.google.charts.load('current', { packages: ['corechart'] });
        window.google.charts.setOnLoadCallback(drawChart);
      }
    };
    document.body.appendChild(script);

    function drawChart() {
      const data = window.google.visualization.arrayToDataTable([
        ['Task', 'Percentage'],
        ['Score', result],
        ['Remaining', 1000 - result],
      ]);

      const options = {
        title: '',
        pieHole: 0.4,
        backgroundColor: 'transparent',
        chartArea: {
          backgroundColor: 'transparent'
        },
        legend: {
          position: 'bottom',
          textStyle: {
            color: 'white'
          }
        },
        titleTextStyle: {
          color: 'white'
        },
      };

      const chart = new window.google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }

    return () => {
      document.body.removeChild(script);
    };
  }, [result]);

  const filterUniqueResults = (results) => {
    const uniqueResults = {};
    results.forEach(res => {
      const key = res.ime_igraca;
      if (!uniqueResults[key] || uniqueResults[key].trenutni_rezultat < res.trenutni_rezultat) {
        uniqueResults[key] = res;
      }
    });
    return Object.values(uniqueResults);
  };

  return (
    <>
      <div className="resultsContainer">
        <MdArrowBack onClick={handleBack} className='backButton'></MdArrowBack>
        <div className="joinGameContainer">
          <h2 className="usernameLabel">{username}, your score is {result}</h2><br />
          <div id="piechart" style={{ width: '900px', height: '500px' }}></div>
          <h3>Previous Results:</h3>
          <table>
            <thead>
              <tr>
                <th>Username</th>
                <th>Score</th>
              </tr>
            </thead>
            <tbody>
              {filterUniqueResults(previousResults).map((res, index) => (
                <tr key={index}>
                  <td>{res.ime_igraca}</td>
                  <td>{res.trenutni_rezultat}</td>
                </tr>
              ))}
              {!previousResults.some(res => res.ime_igraca === username && res.trenutni_rezultat === result) && (
                <tr>
                  <td>{username}</td>
                  <td>{result}</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </>
  );
}

export default ResultsPage;
