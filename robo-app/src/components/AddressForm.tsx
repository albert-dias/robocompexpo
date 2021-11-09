// Import de pacotes
import React, { useEffect, useState } from 'react';
import { StyleSheet } from 'react-native';
import RNGooglePlaces from 'react-native-google-places';
import { ActivityIndicator } from 'react-native-paper';
import Geocoder from 'react-native-geocoding';

// Import de páginas
import { GroupControl, Input } from './GlobalCSS';
import { InputWarning } from './InputWarning';
import theme from '../global/styles/theme';
import { Button } from './Button';
import notify from '../util/notify';

const AddressForm = props => {
    const {
        address, number, complement, city, state, neighborhood, cep,
        setAddress, setNumber, setComplement, setCity, setState,
        setLatitude, setLongitude, setNeighborhood, setCep,
    } = props;

    const [completed, setCompleted] = useState(false);
    const [searchDone, setSearchDone] = useState(false);
    const [addressBlurred, setAddressBlurred] = useState(false);
    const [numberBlurred, setNumberBlurred] = useState(false);
    const [cityBlurred, setCityBlurred] = useState(false);
    const [stateBlurred, setStateBlurred] = useState(false);
    const [neighborhoodBlurred, setNeighborhoodBlurred] = useState(false);
    const [cepBlurred, setCepBlurred] = useState(false);

    const [addressIsEmpty, setAddressIsEmpty] = useState(true);
    const [numberIsEmpty, setNumberIsEmpty] = useState(true);
    const [complementIsEmpty, setComplementIsEmpty] = useState(true);
    const [cityIsEmpty, setCityIsEmpty] = useState(true);
    const [stateIsEmpty, setStateIsEmpty] = useState(true);
    const [neighborhoodIsEmpty, setNeighborhoodIsEmpty] = useState(true);
    const [cepIsEmpty, setCepIsEmpty] = useState(true);

    const [loading, setLoading] = useState(false);

    let hasError = false;

    const checkError = (flag: boolean) => {
        if (flag === true) {
            hasError = true;
        }
        return flag;
    }

    const clear = () => {
        setAddress('');
        setNumber('');
        setComplement('');
        setNeighborhood('');
        setCity('');
        setState('');
        setCep('');

        setAddressIsEmpty(true);
        setNumberIsEmpty(true);
        setComplementIsEmpty(true);
        setNeighborhoodIsEmpty(true);
        setCityIsEmpty(true);
        setStateIsEmpty(true);
        setCepIsEmpty(true);
    };

    const openSearchModal = () => {
        setLoading(true);
        RNGooglePlaces.openAutocompleteModal({
            country: 'BR',
            useOverlay: true,
        },
            ['addressComponents', 'location'])
            .then(place => {
                clear();
                var addressComponents = place.addressComponents;
                addressComponents.forEach(addressComponent => {
                    switch (addressComponent.types[0]) {
                        case 'postal_code':
                            setCep(addressComponent.shortName);
                            setCepIsEmpty(false);
                            break;
                        case 'street_number':
                            setNumber(addressComponent.shortName);
                            setNumberIsEmpty(false);
                            break;
                        case 'route':
                            setAddress(addressComponent.shortName);
                            setAddressIsEmpty(false);
                            break;
                        case 'sublocality_level_1':
                            setNeighborhood(addressComponent.shortName);
                            setNeighborhoodIsEmpty(false);
                            break;
                        case 'administrative_area_level_2':
                            setCity(addressComponent.shortName);
                            setCityIsEmpty(false);
                            break;
                        case 'administrative_area_level_1':
                            setState(addressComponent.shortName);
                            setStateIsEmpty(false);
                            break;
                        default: break;
                    }
                });

                var location = place.location;
                setLongitude(location.longitude);
                setLatitude(location.latitude);

                setCepBlurred(true);
                setAddressBlurred(true);
                setNumberBlurred(true);
                setNeighborhoodBlurred(true);
                setCityBlurred(true);
                setStateBlurred(true);

                setSearchDone(true);

                setLoading(false);
            }).catch(error => {
                console.log('ERROR: ' + error.message);
                setLoading(false);
            });
    };

    const getCurrentAddress = async () => {
        try {
            const response = await RNGooglePlaces.getCurrentPlace();
            notify(JSON.stringify(response), 'success');
        } catch (e) {
            notify(e, 'error');
        }
    };

    useEffect(() =>
        setCompleted(cep !== ''
            && address !== ''
            && number !== ''
            && neighborhood !== ''
            && city !== ''
            && state !== ''), [
        address,
        number,
        neighborhood,
        city,
        state,
        cep
    ]);

    const updateLocation = async () => {
        if (number == '' || address == '' || neighborhood == '' || city == '' || state == '')
            return;
        Geocoder.init('AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y');

        try {
            const geocoderResponse = await Geocoder.from(
                number + ' ' + address + ', ' + neighborhood + ', ' + city + ', ' + state
            );
            var location = geocoderResponse.results[0].geometry.location;
            setLatitude(location.lat);
            setLongitude(location.lng);
            console.log("Location = " + JSON.stringify(location));
        } catch (e) {
            console.log(e);
        }
    };

    return (
        <React.Fragment>
            <GroupControl>
                <Button
                    onPress={openSearchModal}
                    disabled={false}
                    text='Buscar no Google'
                    fullWidth
                    loading={false}
                    backgroundColor={theme.colors.google}
                />
            </GroupControl>
            {loading ? (
                <ActivityIndicator />
            ) : (
                <>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="CEP"
                            value={cep}
                            onChangeText={text => setCep(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setCepBlurred(true)}
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !cepIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(cep === '')}
                            visible={cepBlurred}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Endereço"
                            value={address}
                            onChangeText={text => setAddress(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setAddressBlurred(true)}
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !addressIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(address === '')}
                            visible={addressBlurred}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Número"
                            value={number}
                            onChangeText={text => setNumber(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setNumberBlurred(true)}
                            autoCompleteType="cc-number"
                            keyboardType="numeric"
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !numberIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(number === '')}
                            visible={numberBlurred}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Complemento"
                            value={complement}
                            onChangeText={text => setComplement(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            disabled={!searchDone || !complementIsEmpty}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Bairro"
                            value={neighborhood}
                            onChangeText={(text) => setNeighborhood(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setNeighborhoodBlurred(true)}
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !neighborhoodIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(neighborhood === '')}
                            visible={neighborhoodBlurred}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Cidade"
                            value={city}
                            onChangeText={text => setCity(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setCityBlurred(true)}
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !cityIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(city === '')}
                            visible={cityBlurred}
                        />
                    </GroupControl>
                    <GroupControl>
                        <Input
                            mode="flat"
                            label="Estado"
                            value={state}
                            onChangeText={text => setState(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={() => setStateBlurred(true)}
                            onEndEditing={updateLocation}
                            disabled={!searchDone || !stateIsEmpty}
                        />
                        <InputWarning
                            text="Campo obrigatório"
                            valid={checkError(state === '')}
                            visible={stateBlurred}
                        />
                    </GroupControl>
                </>
            )}
        </React.Fragment>
    );
};

const styles = StyleSheet.create({
    searchbutton: {
        backgroundColor: theme.colors.google,
    },
});

export default AddressForm;