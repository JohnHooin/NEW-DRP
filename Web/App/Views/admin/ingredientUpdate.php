<? require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php") ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Manager Update Ingredient</title>
</head>
<input type="hidden" class="form-control" id="id" name="id" value="<?= $ingredient->getId() ?>">
<body>

    <div class="container py-5">
        <div class="py-3 text-center">
            <h1 class="display-1">Manager Update Ingredient</h1>
        </div>
        
        <form id="ingredient-form" method="POST" enctype="multipart/form-data" style="width: 80vw; margin: 0 auto; padding: 20px; border: 1px solid #e1ebfa; border-radius: 10px; box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 50px; margin-bottom: 50px;">
            <div class="row mb-3 justify-content-center">

               <div class="col-sm-3">
                    <label for="name">(Last: <?= $ingredient->getName()?>)</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$ingredient->getName() ?>">
                </div>

                <div class="col-sm-3">
                    <label for="method">(Last: <?= $ingredient->getCategory()?>)</label>
                    <select class="form-select" id="category" name="category">
                        <? foreach ($opts->validCategories as $opt) : ?>
                        <option value="<?= $opt['id'] ?>" <?= ($ingredient->getCategory() == $opt['detail']) ? 'selected': '';?> ><?= $opt['detail'] ?></option>
                        <? endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="measurement_unit">(Last: <?= $ingredient->getMeasurementUnit()?>)</label>
                    <select class="form-select" id="measurement_unit" name="measurement_unit">
                        <?php foreach ($opts->validMeasurements as $opt) : ?>
                            <option value="<?= $opt['id'] ?>"  <?= ($ingredient->getMeasurementUnit() == $opt['detail']) ? 'selected' : '';?> > <?= $opt['detail'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>



                <div class="col-sm-3">
                    <label class="visually-hidden" for="measurement_unit"></label><br>
                    <input class="form-control px-2" type="text" placeholder="Have a good day sir!" aria-label="Disabled input example" disabled>
                </div>
            </div>


            <div style="display: flex; justify-content: center;">
                <h4 class="m-2">Nutrition components</h2>
            </div>
            <div class="row mb-3 justify-content-center">
                <?php $count = 0; ?>
                <?php foreach ($ingredient->getNutritionComponents() as $nutrition) : ?>
                    <?php if ($count % 4 == 0) : ?>
            </div>
            
            
            <div class="row justify-content-center">
                    <?php endif; ?>
                <div class="col-6 col-md-3">
                <label for="<?= $nutrition['nutrition_id'] ?>">Enter value of <?= $nutrition['nutrition_name'] ?></label>
                <input class="form-control px-2" type="number" id="<?= $nutrition['nutrition_id'] ?>" name="nutritionComponents[<?= $nutrition['nutrition_id'] ?>]" value="<?= $nutrition['nutrition_quantity']?>" step="0.01"><br>
                </div>
                    <?php $count++; ?>
                <?php endforeach; ?>
            </div>


            <div class="d-grid gap-2">
                <button class="btn btn-success" name="update" type="submit">Update</button>
            </div>

            </form>
            <div class="d-md-flex justify-content-md-end py-3">
                <a href="/manager/ingredient" class="btn btn-secondary me-md-2" tabindex="-1" role="button">Back</a>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <? require($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php") ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<script>
  $(document).ready(function() {
    $('#ingredient-form').submit(function(event) {
      event.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
        type: 'POST',
        url: '/manager/ingredient/update',
        data: formData,
        dataType: 'json', 
        success: function(response) {
          if (response.success) {
            alert(response.message);
           
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>