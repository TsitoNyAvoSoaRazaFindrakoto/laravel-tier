const firebaseConfig = {
    apiKey: "AIzaSyD_dhXrU5-3m_QsUAka7FVavlGTgNTlppI",
    authDomain: "crypta-d5e13.firebaseapp.com",
    projectId: "crypta-d5e13",
    storageBucket: "crypta-d5e13.firebasestorage.app",
    messagingSenderId: "539604836728",
    appId: "1:539604836728:web:5876a760ea6bf2189ee88d",
    measurementId: "G-X7J7VJSX4N"
};
firebase.initializeApp(firebaseConfig);
var db = firebase.firestore();

const img=document.getElementById("photo");

db.collection("utilisateur")
    .where("idUtilisateur","==",idUtilisateur)
    .get()
    .then((querySnapshot) => {
        querySnapshot.forEach((doc) => {
            const data = doc.data(); // Données du document
            if(data.img!=undefined){
                img.src=data.img+"&tr=w-130,h-130";
            }
            else{
                img.src="https://ik.imagekit.io/qmegcemhav/profile-pictures/default.jpg?updatedAt=1738953528745&tr=w-130,h-130";
            }
        });
        $scope.paginate(dataCrypto,12);
    })
    .catch((error) => {
        console.error('Erreur lors de la récupération des données:', error);
    });
