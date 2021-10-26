import { PermissionsAndroid } from "react-native";

const pickImage = async (callback: (uri: string) => void) => {
    await PermissionsAndroid.requestMultiple([
        'android.permission.CAMERA',
        'android.permission.WRITE_EXTERNAL_STORAGE'
    ]);
    // ImagePicker.
    // showImagePicker({
    //     allowsEditing: true,
    //     cameraType: 'front',
    //     cancelButtonTitle: 'Cancelar',
    //     chooseFromLibraryButtonTitle: 'Escolher da galeria',
    //     takePhotoButtonTitle: 'Abrir câmera',
    //     title: 'Selecione um método:',
    // }, (response) => {
    //     if (response.didCancel) {
    //         // console.log('User cancelled image picker');
    //     } else if (response.error) {
    //         console.log('ImagePicker Error: ', response.error);
    //     } else if (response.customButton) {
    //         // console.log('User tapped custom button: ', response.customButton);
    //     } else {
    //         callback(response.uri);
    //     }
    // });
};

export default pickImage;