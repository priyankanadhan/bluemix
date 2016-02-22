function incentiveCalculator() {

    this.incentiveForSales = function (RevenueTargetTotal, RevenueAchievedMainProducts, RevenueAchievedaccessoriesProducts) {

        // var RevenueTargetTotal =
        //  Math.round((RevenueTargetMainProducts)) + Math.round((RevenueTargetaccessoriesProducts));

        var RevenueTargetMainProducts = Math.round((RevenueTargetTotal / 100) * 85);

        var RevenueTargetaccessoriesProducts = Math.round((RevenueTargetTotal / 100) * 15);

        var RevenueAchievedTotal =
            Math.round((RevenueAchievedMainProducts)) + Math.round((RevenueAchievedaccessoriesProducts));


        var RevenueAchievedMainProductsPercentage =
            Math.round((RevenueAchievedMainProducts / RevenueTargetMainProducts) * 100);

        var RevenueTargetaccessoriesProductsPercentage =
            Math.round((RevenueAchievedaccessoriesProducts / RevenueTargetaccessoriesProducts) * 100);

        var totalPercentage =
            Math.round((RevenueAchievedTotal / RevenueTargetTotal) * 100);

        var accessoryConnect =
            Math.round(parseInt(RevenueAchievedaccessoriesProducts) / parseInt(RevenueTargetTotal) * 100);

        var accessoryMultiplier = 0;
        switch (true) {

            case (accessoryConnect < 10):

                accessoryMultiplier = 0;
                break;

            case (accessoryConnect == 10):

                accessoryMultiplier = 50;
                break;

            case (accessoryConnect == 11):

                accessoryMultiplier = 60;
                break;

            case (accessoryConnect == 12):

                accessoryMultiplier = 70;
                break;

            case (accessoryConnect == 13):
                accessoryMultiplier = 80;
                break;

            case (accessoryConnect == 14):
                accessoryMultiplier = 90;
                break;

            case (accessoryConnect >= 15):
                accessoryMultiplier = 100;
                break;
        }

        // alert(accessoryMultiplier);

        var incentiveApplicabable1 =
            Math.round((RevenueAchievedTotal / 100) * 0.5);

        var incentiveApplicabable2 =
            Math.round((incentiveApplicabable1 / 100) * totalPercentage);

        var incentiveApplicabable =
            Math.round((incentiveApplicabable2 / 100) * accessoryMultiplier);

        var result = {};


        result.RevenueTargetMainProducts = RevenueTargetMainProducts;
        result.RevenueTargetaccessoriesProducts = RevenueTargetaccessoriesProducts;
        result.RevenueTargetTotal = RevenueTargetTotal;

        result.RevenueAchievedMainProducts = RevenueAchievedMainProducts;
        result.RevenueAchievedaccessoriesProducts = RevenueAchievedaccessoriesProducts;
        result.RevenueAchievedTotal = RevenueAchievedTotal;

        result.RevenueAchievedMainProductsPercentage = RevenueAchievedMainProductsPercentage;
        result.RevenueTargetaccessoriesProductsPercentage = RevenueTargetaccessoriesProductsPercentage;
        result.totalPercentage = totalPercentage;

        result.accessoryConnect = accessoryConnect;
        result.accessoryMultiplier = accessoryMultiplier;
        result.incentiveApplicabable = incentiveApplicabable;

        return result;
    }

    this.incentiveForTechnical = function (revenueTarget, revenueAchived, accessoriesInsurance, unitOfAPPSold) {

        var revenueachivementPercentage =
            Math.round((revenueAchived / revenueTarget) * 100);

        var appMultiplier = 0;

        switch (true) {

            case (unitOfAPPSold <= 20):
                appMultiplier = 100;
                break;
            case (unitOfAPPSold > 20 && unitOfAPPSold <= 30):
                appMultiplier = 125;
                break;
            case (unitOfAPPSold >= 31):
                appMultiplier = 200;
                break;
        }


        var incentiveApplicabable =
            Math.round(((revenueAchived / 100) * 10) + ((accessoriesInsurance / 100) * 2) + (unitOfAPPSold * appMultiplier));

        var result = {};

        result.revenueTarget = revenueTarget;
        result.revenueAchived = revenueAchived;
        result.revenueachivementPercentage = revenueachivementPercentage;
        result.unitOfAPPSold = unitOfAPPSold;
        result.appMultiplier = appMultiplier;
        result.incentiveApplicabable = incentiveApplicabable;

        return result

    }

}
